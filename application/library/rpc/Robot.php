<?php

class Rpc_Robot
{

    private static $_instance = null;

    const CHECK_SCHEDULABLE = '/openapi/v1/robot/schedulable';
    const SCHEDULE = '/openapi/v1/robot/schedule';
    const BACK = '/openapi/v1/robot/back';
    const CANCELL = '/openapi/v1/robot/schedule/cancel';

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

    public static $callbackArray = array(
        'gotoStartCallback' => array(
            'action' => 'gotoStartCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GOING,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_WAIT,
            'notice' => self::NOTICE_STAFF,
        ),

        'arriveStartCallback' => array(
            'action' => 'arriveStartCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GOING,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_WAIT,
            'notice' => self::NOTICE_STAFF,
        ),

        'gotoTargetCallback' => array(
            'action' => 'gotoTargetCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GOING,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
            'notice' => self::NOTICE_BOTH,
        ),

        'arriveTargetCallback' => array(
            'action' => 'arriveTargetCallback',
            'status' => Enum_ShoppingOrder::ROBOT_ARRIVED,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
            'notice' => self::NOTICE_BOTH,
        ),

        'successCallback' => array(
            'action' => 'successCallback',
            'status' => Enum_ShoppingOrder::ROBOT_FINISHED,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_COMPLETE,
            'notice' => self::NOTICE_BOTH,
        ),
        'failCallback' => array(
            'action' => 'failCallback',
            'status' => Enum_ShoppingOrder::ROBOT_GUEST_NOT_FETCH,
            'orderStatus' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
            'notice' => self::NOTICE_BOTH,
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
     */
    private function _makeUrl(string $interface, array $params, bool $withCallback = true): array
    {
        $ts = intval(microtime(true) * 1000);
        $params['placeId'] = $this->_placeId;
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
     * @param int $taskId
     * @throws Exception
     */
    public function callback(string $action, int $taskId)
    {
        $robotTaskDao = new Dao_RobotTask();
        $shoppingOrderDao = new Dao_ShoppingOrder();
        $staffDao = new Dao_Staff();
        $taskInfo = $robotTaskDao->getRobotTaskDetail($taskId);
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
            $pushParams['contentValue'] = $taskId;
            $pushParams['dataid'] = $orderList[0]['id']; // user id

            $pushModel->addPushOne($pushParams);
        }

        //push MSG to staff
        if ($notice == Rpc_Robot::NOTICE_BOTH || $notice == Rpc_Robot::NOTICE_STAFF) {
            $count = 0;
            $content = Enum_ShoppingOrder::getRobotStatusNameList()[$taskUpdate['status']];
            $enContent = Enum_ShoppingOrder::getRobotStatusNameList()[Enum_Lang::ENGLISH][$taskUpdate['status']];
            $title = $content;
            $enTitle = $enContent;

            $pushParams = array();
            $pushParams['cn_title'] = $title;
            $pushParams['cn_value'] = $content;
            $pushParams['en_title'] = $enTitle;
            $pushParams['en_value'] = $enContent;
            $pushParams['type'] = Enum_Push::PUSH_TYPE_STAFF;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
            $pushParams['contentValue'] = $taskId;

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


        //update robot task and order status
        $robotTaskDao->updateTask($taskUpdate, $taskId);
        foreach ($orderIdArray as $orderId) {
            $shoppingOrderDao->updateShoppingOrderById($orderUpdate, $orderId);
        }
    }

}