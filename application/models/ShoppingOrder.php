<?php

/**
 * Class ShoppingOrderModel
 * 购物订单管理Model
 */
class ShoppingOrderModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShoppingOrder();
    }

    /**
     * 获取ShoppingOrder列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingOrderList(array $param) {
        $paramList = array();
        $param['shoppingid'] ? $paramList['shoppingid'] = strval($param['shoppingid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['userid'] ? $paramList['userid'] = intval($param['userid']) : false;
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['status'] ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShoppingOrderList($paramList);
    }

    /**
     * Get filter field info for shopping order
     *
     * @param array $param
     * @return array
     */
    public function getShoppingOrderFilterList(array $param):array {
        $paramList = array();
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getShoppingOrderFilter($paramList);
    }

    /**
     * 获取ShoppingOrder数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingOrderCount(array $param) {
        $paramList = array();
        $param['shoppingid'] ? $paramList['shoppingid'] = strval($param['shoppingid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['userid'] ? $paramList['userid'] = intval($param['userid']) : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getShoppingOrderCount($paramList);
    }

    /**
     * 根据id查询ShoppingOrder信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShoppingOrderDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShoppingOrderDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ShoppingOrder信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShoppingOrderById($param, $id) {
        $result = false;
        if ($id) {
            $info['status'] = intval($param['status']);
            $info['adminid'] = intval($param['adminid']);
            $result = $this->dao->updateShoppingOrderById($info, $id);
        }
        return $result;
    }

    /**
     * ShoppingOrder新增信息
     *
     */
    public function addShoppingOrder(array $param) {
        $info['count'] = intval($param['count']);
        $info['shoppingid'] = intval($param['shoppingid']);
        $info['hotelid'] = intval($param['hotelid']);
        $info['userid'] = intval($param['userid']);
        $info['creattime'] = time();
        $info['status'] = Enum_ShowingOrder::ORDER_STATUS_WAIT;
	    $this->_emailShoppingOrder($info);
        return $this->dao->addShoppingOrder($info);
    }


    /**
     * Send the detail of the order to manager
     *
     * @param array $info
     * @return bool
     */
    private function _emailShoppingOrder($info)
    {
        $to = $this->_getEmailArray($info['hotelid']);
        if (empty($to)) {
            return false;
        }
        $shoppingDao = new Dao_Shopping();
        $userDao = new Dao_User();
        $userDetail = $userDao->getUserDetail($info['userid']);
        $shoppingDetail = $shoppingDao->getShoppingDetail($info['shoppingid']);
        $shoppingDetail['url'] = Enum_Img::getPathByKeyAndType($shoppingDetail ['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750);

        $mailTemplate = "
        <head>
            <meta charset=\"UTF-8\">
        </head>
           <p>客房：%s</p> 
           <p>房客：%s</p> 
           <p>定单：%s X %s</p> 
           <p>下单时间： %s</p>
           <p>价格：%s</p>
           <p><img src='%s'/></p>
           
        </body>
        ";

        $mailContent = sprintf($mailTemplate, $userDetail['room_no'], $userDetail['fullname'],
            $shoppingDetail['title_lang1'], $info['count'],
            date("Y-m-d H:i:s", $info['creattime']),
            $shoppingDetail['price'],
            $shoppingDetail['url']
        );
        $subject = "体验购物定单：" . $userDetail['room_no'] . "-" . $shoppingDetail['title_lang1'] . "X" . $info['count'];
        $smtp = Mail_Email::getInstance();

        $smtp->addCc('iservice@liheinfo.com');
        $smtp->send($to, $subject, $mailContent);
        return true;
    }


    /**
     * @param $hotelId
     * @return array|null
     */
    private function _getEmailArray($hotelId)
    {
        $data = array(
            6 => array(
                'fangzhou@liheinfo.com' => 'Fangzhou',
                'frank@itearoa.co.nz' => 'frank'
            ),
            1 => array(
                'frontoffice.arcb@the-ascott.com' => 'rontoffice.arcb',
                'miki.wu@the-ascott.com' => 'miki.wu',
                'tracy.han@the-ascott.com' => 'tracy.han',

            )
        );

        return $data[$hotelId];
    }


    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public function robotDeliver($params)
    {
        $daoRobotTask = new Dao_RobotTask();
        $daoBase = new Dao_Base();
        $daoShoppingOrder = new Dao_ShoppingOrder();
        $orderArray = $daoShoppingOrder->getShoppingOrderInfo($params['itemlist']);
        $daoRobotTask->hasSameRoomNo($orderArray);

        try {
            $daoBase->beginTransaction();
            $item = array(
                'userid' => $params['userid'],
                'orders' => json_encode($params['itemlist']),
                'status' => Enum_ShoppingOrder::ROBOT_BEGIN,
            );
            $orderUpdate = array(
                'robot_status' => Enum_ShoppingOrder::ROBOT_BEGIN,
                'status' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
                'adminid' => $params['userid']
            );
            $robotTaskId = $daoRobotTask->addTask($item);
            foreach ($params['itemlist'] as $orderId){
                $daoShoppingOrder->updateShoppingOrderById($orderUpdate, $orderId);
            }

            $apiParamArray = array(
                'taskid' => $robotTaskId,
                'start' => $params['start'],
                'target' => $orderArray[0]['room_no']
            );

            $rpcObject = Rpc_Robot::getInstance();
            $rpcJson = $rpcObject->send(Rpc_Robot::SCHEDULE, $apiParamArray);
            $info['robot_detail'] = json_encode($rpcJson);
            $flag = $daoRobotTask->updateTask($info, $robotTaskId);
            if (!$flag || $rpcJson['errcode'] != 0) {
                throw new Exception(json_encode($rpcJson['data']), $rpcJson['errcode']);
                $a=0;
            }
            $daoBase->commit();
            $result = array(
                'code' => 0,
                'msg' => 'success',
                'data' => array(
                    'serviceId' => $robotTaskId,
                    'robotId' => $rpcJson['data']['taskId']
                )
            );
            return $result;
        } catch (Exception $e) {
            $daoBase->rollback();
            throw $e;

        }

    }

    /**
     * @param $target
     * @return mixed
     * @throws Exception
     */
    public function callRobot($target){

        $param['target'] = $target;
        $param['goback'] = "false";
        $rpcObject = Rpc_Robot::getInstance();
        $rpcJson = $rpcObject->send(Rpc_Robot::SCHEDULE, $param, false);
        if($rpcJson['errcode'] != 0) {
            throw new Exception($rpcJson['errmsg'], $rpcJson['errcode']);
        }
        return $rpcJson;

    }
}
