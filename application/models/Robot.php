<?php

/**
 * Class RobotModel
 */
class RobotModel extends \BaseModel
{
    const ROBOT_GUIDE = 'guide';
    const ROBOT_TASK_GETITEM = 'getitem';

    private $dao;

    public function __construct()
    {
        parent::__construct();
        $this->dao = new Dao_RobotPosition();
    }

    /**
     * Get robot position list
     *
     * @param array $param
     * @return array
     */
    public function getPositionList(array $param)
    {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['type'] ? $paramList['type'] = intval($param['type']) : false;
        $param['position'] ? $paramList['position'] = trim($param['position']) : false;

        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPositionList($paramList);
    }

    /**
     * Get count of robot_position
     *
     * @param array $param
     * @return int
     */
    public function getPositionCount(array $param): int
    {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['type'] ? $paramList['type'] = intval($param['type']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['position'] ? $paramList['position'] = trim($param['position']) : false;

        return $this->dao->getRobotPositionCount($paramList);
    }

    /**
     * Get robot position detail by ID
     *
     * @param $id
     * @return array
     */
    public function getPositionDetail($id)
    {
        $result = array();
        if ($id) {
            $result = $this->dao->getRobotPositionDetail($id);
        }
        return $result;
    }

    /**
     * Update robot position by ID
     *
     * @param $param
     * @param $id
     * @return bool|string
     */
    public function updatePositionById($param, $id)
    {
        $result = false;
        if ($id) {
            $info['userid'] = intval($param['userid']);
            $info['type'] = intval($param['type']);
            $info['position'] = trim($param['position']);
            $info['robot_position'] = trim($param['robot_position']);

            $result = $this->dao->updatePosition($info, $id);
        }
        return $result;
    }

    /**
     * Add new pair of robot position
     *
     * @param array $param
     * @return int
     * @throws Exception
     */
    public function addRobotPosition(array $param): int
    {
        $info = array();
        !is_null($param['hotelid']) ? $info['hotelid'] = intval($param['hotelid']) : false;
        !is_null($param['position']) ? $info['position'] = trim($param['position']) : false;
        if (empty($info)) {
            throw new Exception("Lack of param");
        }
        $isExist = $this->dao->getRobotPositionCount($info);
        if ($isExist > 0) {
            throw new Exception("Position already exist", 1);
        }
        !is_null($param['userid']) ? $info['userid'] = intval($param['userid']) : false;
        !is_null($param['robot_position']) ? $info['robot_position'] = trim($param['robot_position']) : false;
        !is_null($param['type']) ? $info['type'] = intval($param['type']) : false;
        return $this->dao->addPosition($info);

    }

    /**
     * Call robot or robot guide
     *
     * @param $target
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function callRobot(array $params)
    {
        $position = $this->getPositionDetail($params['target']);
        $target = $position['robot_position'];
        if (empty($target)) {
            throw new Exception("param error", 1);
        } else {
            $param['target'] = $target;
        }
        if ($params['type'] == self::ROBOT_GUIDE) {
            $param['type'] = self::ROBOT_GUIDE;
        } else {
            $param['goback'] = "false";
        }
        $param['hotelid'] = $params['hotelid'];
        $rpcObject = Rpc_Robot::getInstance();
        $rpcJson = $rpcObject->send(Rpc_Robot::SCHEDULE, $param, false);
        $info = array(
            'userid' => $params['userid'],
            'hotelid' => $params['hotelid'],
            'params' => json_encode($param),
            'result' => json_encode($rpcJson),
        );
        $robotActionModel = new Dao_RobotAction();
        $robotActionModel->addRobotAction($info);
        if ($rpcJson['errcode'] != 0) {
            throw new Exception($rpcJson['errmsg'], $rpcJson['errcode']);
        }
        return $rpcJson;

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
        $robotModel = new RobotModel();

        $orderArray = $daoShoppingOrder->getShoppingOrderInfo($params['itemlist']);
        $daoRobotTask->hasSameRoomNo($orderArray);
        if ($params['dest'] == 0) {
            $positionArray = $robotModel->getPositionList(array(
                'position' => $orderArray[0]['room_no']
            ));
            $target = $positionArray[0]['robot_position'];
        } else {
            $position = $robotModel->getPositionDetail($params['dest']);
            $target = $position['robot_position'];
        }
        if (empty($target)) {
            throw new Exception(Enum_ShoppingOrder::EXCEPTION_HAVE_NO_DEST, Enum_ShoppingOrder::ORDERS_POSITION_NOT_EXIST);
        }
        $startPosition = $robotModel->getPositionDetail($params['start']);
        $start = $startPosition['robot_position'];


        try {
            $daoBase->beginTransaction();
            $item = array(
                'userid' => $params['userid'],
                'orders' => json_encode($params['itemlist']),
                'status' => Enum_ShoppingOrder::ROBOT_BEGIN,
                'createtime' => time(),
            );
            $orderUpdate = array(
                'robot_status' => Enum_ShoppingOrder::ROBOT_BEGIN,
                'status' => Enum_ShoppingOrder::ORDER_STATUS_SERVICE,
                'adminid' => $params['userid']
            );
            $robotTaskId = $daoRobotTask->addTask($item);
            foreach ($params['itemlist'] as $orderId) {
                $daoShoppingOrder->updateShoppingOrderById($orderUpdate, $orderId);
            }

            $apiParamArray = array(
                'robottaskid' => $robotTaskId,
                'from' => $start,
                'to' => $target,
                'hotelid' => $params['hotelid'],
            );

            $rpcObject = Rpc_Robot::getInstance();
            $rpcJson = $rpcObject->send(Rpc_Robot::SENDITEM, $apiParamArray);
            $info['robot_detail'] = json_encode($rpcJson);
            $flag = $daoRobotTask->updateTask($info, $robotTaskId);
            if (!$flag || !$rpcJson || $rpcJson['errcode'] != 0) {
                throw new Exception(json_encode($rpcJson['data']), $rpcJson['errcode']);
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
     * User call robot to his room to send items
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getItem(array $params)
    {
        $userDao = new Dao_User();
        $userDetail = array();
        if (!empty($params['start']) && !empty($params['dest'])) {
            $roomPosition = $this->dao->getRobotPositionDetail($params['start']);
            $toPosition = $this->dao->getRobotPositionDetail($params['dest']);
            if ($roomPosition['position']) {
                $userList = $userDao->getUserList(array(
                    'room_no' => $roomPosition['position'],
                    'hotelid' => $roomPosition['hotelid'],
                    'limit' => 1
                ));
                if (count($userList) == 1) {
                    $userDetail = $userList[0];
                    $params['userid'] = $userDetail['id'];
                    $from = $roomPosition['robot_position'];
                    $to = $toPosition['robot_position'];
                }
            }
        }

        if (empty($params['userid']) || (empty($params['to']) && empty($params['dest']))) {
            $this->throwException('Lack of param', Enum_Robot::EXCEPTION_OUTPUT_NUM);
        }
        if (empty($userDetail)) {
            $userDetail = $userDao->getUserDetail($params['userid']);
        }
        $roomNo = $userDetail['room_no'];
        if (empty($roomNo) || empty($userDetail['hotelid'])) {
            throw new Exception(Enum_Robot::EXCEPTION_CANNOT_FIND_YOUR_ROOM, Enum_Robot::EXCEPTION_OUTPUT_NUM);
        }
        $params['hotelid'] = intval($userDetail['hotelid']);
        if (empty($from)) {
            $roomPosition = $this->dao->getPositionList(array(
                'position' => $roomNo,
                'hotelid' => $params['hotelid'],
                'limit' => 1
            ));
            $from = strval($roomPosition[0]['robot_position']);
            if (count($roomPosition) != 1 || empty($from)) {
                throw new Exception(Enum_Robot::EXCEPTION_ROOM_NOT_TAGGED, Enum_Robot::EXCEPTION_OUTPUT_NUM);
            }
        }

        if (empty($to)) {
            $toPosition = $this->dao->getPositionList(array(
                'position' => $params['to'],
                'hotelid' => intval($userDetail['hotelid']),
                'limit' => 1
            ));
            $to = $toPosition[0]['robot_position'];
            if (count($toPosition) != 1 || empty($to)) {
                throw new Exception(Enum_Robot::EXCEPTION_POSITION_NOT_FOUND . "(${params['to']})", Enum_Robot::EXCEPTION_OUTPUT_NUM);
            }
        }

        $daoRobotTask = new Dao_RobotTask();
        try {
            $this->dao->beginTransaction();
            $item = array(
                'userid' => $params['userid'],
                'orders' => self::ROBOT_TASK_GETITEM,
                'status' => Enum_Robot::ROBOT_BEGIN,
                'createtime' => time(),
            );
            $robotTaskId = $daoRobotTask->addTask($item);

            $apiParamArray = array(
                'robottaskid' => $robotTaskId,
                'from' => $from,
                'to' => $to,
                'hotelid' => $params['hotelid'],
            );

            $rpcObject = Rpc_Robot::getInstance();
            $rpcJson = $rpcObject->send(Rpc_Robot::GETITEM, $apiParamArray);
            if (is_null($rpcJson)) {
                $this->throwException('Error occurred when deal with robot api', Enum_Robot::EXCEPTION_OUTPUT_NUM);
            }
            $info['robot_detail'] = json_encode($rpcJson);
            $flag = $daoRobotTask->updateTask($info, $robotTaskId);
            if (!$flag || $rpcJson['errcode'] != 0) {
                throw new Exception(json_encode($rpcJson['data']), $rpcJson['errcode']);
            }
            $this->dao->commit();
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
            $this->dao->rollback();
            throw $e;

        }

    }

    /**
     * Send robot back to charging point
     *
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function backToCharge($params)
    {
        if (!$params['hotelid'] || !$params['userid'] || empty($params['productId'])) {
            $this->throwException('Lack of param', 1);
        }
        $rpcObject = Rpc_Robot::getInstance();
        $rpcJson = $rpcObject->send(Rpc_Robot::BACK, $params, false);
        $info = array(
            'userid' => $params['userid'],
            'hotelid' => $params['hotelid'],
            'params' => json_encode($params),
            'result' => json_encode($rpcJson),
        );
        $robotActionModel = new Dao_RobotAction();
        $robotActionModel->addRobotAction($info);
        if ($rpcJson['errcode'] != 0) {
            $this->throwException($rpcJson['errmsg'], $rpcJson['errcode']);
        }
        return $rpcJson;
    }

    public function getItemList($params)
    {

        $params['id'] ? $paramList['id'] = intval($params['id']) : false;
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['userid'] ? $paramList['userid'] = intval($params['userid']) : false;
        $params['status'] ? $paramList['status'] = trim($params['status']) : false;
        $params['orders'] ? $paramList['orders'] = trim($params['orders']) : false;

        $paramList['limit'] = $params['limit'];
        $paramList['page'] = $params['page'];

        $dao = new Dao_RobotTask();
        return $dao->getRobotTaskList($params);
    }

    public function getItemListCount($params)
    {
        $params['id'] ? $paramList['id'] = intval($params['id']) : false;
        $params['hotelid'] ? $paramList['hotelid'] = intval($params['hotelid']) : false;
        $params['userid'] ? $paramList['userid'] = intval($params['userid']) : false;
        $params['status'] ? $paramList['status'] = trim($params['status']) : false;
        $params['orders'] ? $paramList['orders'] = trim($params['orders']) : false;

        $dao = new Dao_RobotTask();
        return $dao->getRobotTaskListCount($params);
    }

}
