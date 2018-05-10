<?php

class Rpc_Robot
{

    private static $_instance = null;

    const CHECK_SCHEDULABLE = '/openapi/v1/robot/schedulable';
    const SCHEDULE = '/openapi/v1/robot/schedule';
    const BACK = '/openapi/v1/robot/back';
    const CANCELL = '/openapi/v1/robot/schedule/cancel';
    const GETITEM = '/openapi/v1/robot/schedule/getitem';
    const SENDITEM = '/openapi/v1/robot/schedule/transport';

    const CALLBACK_URI = "/service/robotCallback";

    const NOTICE_NONE = 0;
    const NOTICE_GUEST = 1;
    const NOTICE_STAFF = 2;
    const NOTICE_BOTH = 3;

    private $_appName;
    private $_secretKey;
    private $_placeId;
    private $_domain;
    private $_callbackDomain;

    /**
     * @var Dao_RobotTask
     */
    private $_robotTaskDao;

    public static $callbackArray = array(
        'gotoStartCallback' => array(
            'action' => 'gotoStartCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GOING,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_WAIT,
            'notice' => self::NOTICE_STAFF,
            'sendNotice' => self::NOTICE_GUEST
        ),

        'arriveStartCallback' => array(
            'action' => 'arriveStartCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GOING,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_WAIT,
            'notice' => self::NOTICE_STAFF,
            'sendNotice' => self::NOTICE_GUEST
        ),

        'gotoTargetCallback' => array(
            'action' => 'gotoTargetCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GOING,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
            'notice' => self::NOTICE_BOTH,
            'sendNotice' => self::NOTICE_NONE
        ),

        'arriveTargetCallback' => array(
            'action' => 'arriveTargetCallback',
            'status' => Enum_ShoppingOrder::ROBOT_ARRIVED,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
            'notice' => self::NOTICE_BOTH,
            'sendNotice' => self::NOTICE_GUEST
        ),

        'successCallback' => array(
            'action' => 'successCallback',
            'status' => Enum_ShoppingOrder::ROBOT_FINISHED,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_COMPLETE,
            'notice' => self::NOTICE_BOTH,
            'sendNotice' => self::NOTICE_GUEST

        ),
        'failCallback' => array(
            'action' => 'failCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GUEST_NOT_FETCH,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
            'notice' => self::NOTICE_BOTH,
            'sendNotice' => self::NOTICE_NONE
        ),
    );

    public function __construct()
    {
        $robotConfig = Yaf_Registry::get('sysConfig')['robot'];
        $this->_appName = $robotConfig['appName'];
        $this->_secretKey = $robotConfig['secretKey'];
        $this->_placeId = $robotConfig['placeId'];
        $this->_domain = $robotConfig['domain'];
        $this->_callbackDomain = $robotConfig['callbackdomain'];
        $this->_robotTaskDao = new Dao_RobotTask();

    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Generate signature string
     *
     * @param string $interface
     * @param array $params
     * @param bool $withCallback
     * @return array
     * @throws Exception
     */
    private function _makeUrl(string $interface, array $params, bool $withCallback = true): array
    {
        $ts = intval(microtime(true) * 1000);
        if (trim($this->_placeId[$params['hotelid']])) {
            $params['placeId'] = trim($this->_placeId[$params['hotelid']]);
        } else {
            throw new Exception("placeId not configured", 1);
        }
        unset($params['hotelid']);
        if ($withCallback && $params['robottaskid']) {
            $callbackParams = $this->_getCallbackUrl($params['robottaskid']);
            unset($params['robottaskid']);
            $params = array_merge($params, $callbackParams);
        }
        ksort($params);
        $string = '';
        foreach ($params as $key => $value) {
            $string .= $key . ":" . $value . "|";
        }
        $string .= "appname:" . $this->_appName . "|";
        $string .= "secret:" . $this->_secretKey . "|";
        $string .= "ts:" . $ts;
        $sign = md5($string);

        $params['appname'] = $this->_appName;
        $params['ts'] = $ts;
        $params['sign'] = $sign;

        $result = array(
            'url' => $this->_domain . $interface,
            'data' => $params
        );

        return $result;
    }

    /**
     * Get call back url with signature
     *
     * @param int $taskId
     * @return array
     */
    private function _getCallbackUrl(int $taskId): array
    {
        $result = array();
        foreach (self::$callbackArray as $key => $value) {
            $getParam = array();
            $getParam['action'] = $value['action'];
            $getParam['robottaskid'] = $taskId;
            $getParam['appname'] = $this->_appName;
            $getParam['time'] = time();
            $uri = $this->_callbackDomain . self::CALLBACK_URI . "?" . http_build_query($getParam);
            $result[$key] = $uri;
        }
        return $result;
    }

    /**
     * @param $interface
     * @param $params
     * @param bool $withCallback
     * @param int $timeOut
     * @return mixed
     */
    public function send($interface, $params, $withCallback = true, $method = "POST", $timeOut = 10)
    {
        $url = $this->_makeUrl($interface, $params, $withCallback);
        $response = Rpc_Curl::request($url['url'], $method, $url['data'], true, $timeOut);
        return $response;
    }

    /**
     * Update order status through callback method
     *
     * @param string $action
     * @param array $taskInfo
     * @throws Exception
     */
    private function _sendCallback(string $action, array $taskInfo)
    {
        $shoppingOrderDao = new Dao_ShoppingOrder();
        $staffDao = new Dao_Staff();

        $orderIdArray = json_decode($taskInfo['orders'], true);
        if (is_array(Rpc_Robot::$callbackArray[$action])) {
            $taskUpdate['status'] = Rpc_Robot::$callbackArray[$action]['status'];
            $orderUpdate['robot_status'] = Rpc_Robot::$callbackArray[$action]['status'];
            $orderUpdate['status'] = Rpc_Robot::$callbackArray[$action]['orderStatus'];
        } else {
            throw new Exception("参数错误");
        }
        if (count($orderIdArray) == 0) {
            throw new Exception("参数错误");
        }
        $orderList = $shoppingOrderDao->getShoppingOrderInfo($orderIdArray);
        if (count($orderList) == 0) {
            throw new Exception("参数错误");
        }
        $notice = Rpc_Robot::$callbackArray[$action]['notice'];
        $pushModel = new PushModel();
        //push MSG to guest
        if ($notice == Rpc_Robot::NOTICE_BOTH || $notice == Rpc_Robot::NOTICE_GUEST) {
            $content = Enum_ShoppingOrder::getRobotStatusNameListForGuest()[$taskUpdate['status']];
            $enContent = Enum_ShoppingOrder::getRobotStatusNameListForGuest(Enum_Lang::ENGLISH)[$taskUpdate['status']];
            $title = $content;
            $enTitle = $enContent;
            $pushParams = array();

            $pushParams['cn_title'] = $title;
            $pushParams['cn_value'] = $content;
            $pushParams['en_title'] = $enTitle;
            $pushParams['en_value'] = $enContent;
            $pushParams['type'] = Enum_Push::PUSH_TYPE_USER;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
            $pushParams['contentValue'] = $taskInfo['id'];
            $pushParams['dataid'] = $orderList[0]['id']; // user id

            $pushModel->addPushOne($pushParams);
        }

        //update robot task and order status
        $this->_robotTaskDao->updateTask($taskUpdate, $taskInfo['id']);
        foreach ($orderIdArray as $orderId) {
            $shoppingOrderDao->updateShoppingOrderById($orderUpdate, $orderId);
        }

        //push MSG to staff
        if ($notice == Rpc_Robot::NOTICE_BOTH || $notice == Rpc_Robot::NOTICE_STAFF) {
            $count = 0;
            $content = Enum_ShoppingOrder::getRobotStatusNameList()[$taskUpdate['status']];
            $enContent = Enum_ShoppingOrder::getRobotStatusNameList(Enum_Lang::ENGLISH)[$taskUpdate['status']];
            $title = $content;
            $enTitle = $enContent;

            $pushParams = array();
            $pushParams['cn_title'] = $title;
            $pushParams['cn_value'] = $content;
            $pushParams['en_title'] = $enTitle;
            $pushParams['en_value'] = $enContent;
            $pushParams['type'] = Enum_Push::PUSH_TYPE_STAFF;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
            $pushParams['contentValue'] = $taskInfo['id'];

            $staffList = $staffDao->getStaffList(array('hotelid' => $orderList[0]['hotelid']));
            foreach ($staffList as $staffInfo) {
                $pushParams['dataid'] = $staffInfo['id'];
                $pushModel->addPushOne($pushParams);
                $count++;

            }
            if ($count == 0) {
                throw new Exception(PushModel::MESSAGE_NOT_RECEIVED);
            }
        }
    }

    /**
     * Callback for get item
     *
     * @param string $action
     * @param array $taskInfo
     * @throws Exception
     */
    private function _getCallback(string $action, array $taskInfo)
    {
        if (is_array(Rpc_Robot::$callbackArray[$action])) {
            $taskUpdate['status'] = Rpc_Robot::$callbackArray[$action]['status'];
        } else {
            throw new Exception("参数错误");
        }

        $notice = Rpc_Robot::$callbackArray[$action]['sendNotice'];
        $pushModel = new PushModel();
        //push MSG to guest
        if ($notice == Rpc_Robot::NOTICE_BOTH || $notice == Rpc_Robot::NOTICE_GUEST) {
            $content = Enum_Robot::getRobotStatusNameListForGuest()[$taskUpdate['status']];
            $enContent = Enum_Robot::getRobotStatusNameListForGuest(Enum_Lang::ENGLISH)[$taskUpdate['status']];
            $title = $content;
            $enTitle = $enContent;
            $pushParams = array();

            $pushParams['cn_title'] = $title;
            $pushParams['cn_value'] = $content;
            $pushParams['en_title'] = $enTitle;
            $pushParams['en_value'] = $enContent;
            $pushParams['type'] = Enum_Push::PUSH_TYPE_USER;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
            $pushParams['contentValue'] = $taskInfo['id'];
            $pushParams['dataid'] = $taskInfo['userid']; // user id

            $pushModel->addPushOne($pushParams);
        }
        //update robot task status
        $this->_robotTaskDao->updateTask($taskUpdate, $taskInfo['id']);
    }

    public function callback(string $action, int $taskId)
    {
        $taskInfo = $this->_robotTaskDao->getRobotTaskDetail($taskId);
        $orderIdArray = json_decode($taskInfo['orders'], true);
        if (!is_array(Rpc_Robot::$callbackArray[$action])) {
            throw new Exception("参数错误");
        }
        if (count($orderIdArray) == 0) {
            $this->_getCallback($action, $taskInfo);
        } else {
            $this->_sendCallback($action, $taskInfo);
        }
    }
}