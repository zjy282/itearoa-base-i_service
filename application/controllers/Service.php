<?php

/**
 * Controller for service
 *
 */
class ServiceController extends \BaseController
{

    /**
     * @var RobotModel
     */
    private $_model;

    /**
     * @var Convertor_Robot
     */
    private $convertor;

    public function init()
    {
        parent::init();
        $this->_model = new RobotModel();
        $this->convertor = new Convertor_Robot();
    }


    public function callRobotAction()
    {
        $params['target'] = trim($this->getParamList('dest'));
        $params['type'] = trim($this->getParamList('type'));
        $params['hotelid'] = intval($this->getParamList('hotelid'));
        $params['userid'] = intval($this->getParamList('userid'));

        try {
            $response = $this->_model->callRobot($params);
            if ($response['errcode'] != 0) {
                throw new Exception($response['errmsg'], $response['errcode']);
            } else {
                $result = array(
                    'code' => 0,
                    'msg' => 'Success',
                    'data' => array(
                        'taskId' => $response['data']['taskId']
                    )
                );
            }
        } catch (Exception $e) {
            Log_File::writeLog('robotShopping', $e->getMessage() . "\n" . $e->getTraceAsString());
            $result = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array()
            );
        }
        $this->echoJson($result);
    }

    public function deliverRobotAction()
    {
        $params['hotelid'] = intval($this->getParamList('hotelid'));
        $params['userid'] = intval($this->getParamList('userid'));
        $params['start'] = intval($this->getParamList('start'));
        $params['dest'] = intval($this->getParamList('dest'));
        $params['itemlist'] = json_decode($this->getParamList('itemlist'), true);
        $params['time'] = $this->getParamList('time', time());

        try {
            $result = $this->_model->robotDeliver($params);
        } catch (Exception $e) {
            Log_File::writeLog('robotShopping', $e->getMessage() . "\n" . $e->getTraceAsString());
            if ($e->getMessage() == Enum_ShoppingOrder::EXCEPTION_DIFFERENT_ROOM
                || $e->getMessage() == Enum_ShoppingOrder::EXCEPTION_HAVE_NO_DEST
                || $e->getCode() == Enum_ShoppingOrder::EXCEPTION_ERROR_OUTPUT) {
                $msg = $e->getMessage();
            } else {
                $msg = Enum_System::MSG_SYSTEM_ERROR;
            }
            $result = array(
                'code' => 1,
                'msg' => $msg,
                'data' => array()
            );
        }

        $this->echoJson($result);
    }

    /**
     * Action for guest sending item
     */
    public function robotSendAction()
    {
        $params = array();
        $token = trim($this->getParamList('token'));
        $params['to'] = trim($this->getParamList('to', '洗衣房'));
        $params['userid'] = intval(Auth_Login::getToken($token));
        $params['start'] = intval($this->getParamList('start'));
        $params['dest'] = intval($this->getParamList('dest'));
        if ($params['userid'] <= 0) {
            $params['userid'] = intval($this->getParamList('userid'));
        }

        try {
            $result = $this->_model->getItem($params);
            if ($result['code'] == 0) {
                $this->_model->sendRobotTaskMsg($result['data']['serviceId']);
            }
        } catch (Exception $e) {
            Log_File::writeLog('robotAction', $e->getMessage() . "\n" . $e->getTraceAsString());
            if ($e->getCode() == Enum_Robot::EXCEPTION_OUTPUT_NUM) {
                $msg = $e->getMessage();
            } else {
                $msg = Enum_System::MSG_SYSTEM_ERROR;
            }
            $result = array(
                'code' => 1,
                'msg' => $msg,
                'data' => array()
            );
        }

        $this->echoJson($result);
    }

    public function getRobotSendListAction(){
        $params = array();
        $params['id'] = $this->getParamList('id');
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['room_no'] = $this->getParamList('room_no');
        $params['status'] = $this->getParamList('status');
        $params['page'] = $this->getParamList('page');
        $params['limit'] = $this->getParamList('limit');
        $params['orders'] = RobotModel::ROBOT_TASK_GETITEM;

        $data = $this->_model->getItemList($params);
        $count = $this->_model->getItemListCount($params);
        $data = $this->convertor->getRobotSendListConvertor($data, $count, $params);
        $this->echoSuccessData($data);
    }

    /**
     * Action for robot callback
     */
    public function robotCallbackAction()
    {
        $action = $this->getParamList('action');
        $taskId = intval($this->getParamList('robottaskid'));

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );

        try {
            $rpcRobot = Rpc_Robot::getInstance();
            $rpcRobot->callback($action, $taskId);

        } catch (Exception $e) {
            Log_File::writeLog('RobotDeliver', $e->getTraceAsString());
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();

        }

        $this->echoJson($result);
    }

    /**
     * Action for send robot back to charging point
     */
    public function robotBackAction()
    {
        $params = array();
        $params['productId'] = trim($this->getParamList('productid'));
        $params['hotelid'] = intval($this->getParamList('hotelid'));
        $params['userid'] = intval($this->getParamList('userid'));

        try {
            $response = $this->_model->backToCharge($params);
            if ($response['errcode'] != 0) {
                throw new Exception($response['errmsg'], $response['errcode']);
            } else {
                $result = array(
                    'code' => 0,
                    'msg' => 'Success',
                    'data' => array(
                        'taskId' => $response['data']['taskId']
                    )
                );
            }
        } catch (Exception $e) {
            Log_File::writeLog('robotShopping', $e->getMessage() . "\n" . $e->getTraceAsString());
            $result = array(
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'data' => array()
            );
        }
        $this->echoJson($result);
    }

    /**
     * Action for adding new position
     */
    public function addPositionAction()
    {
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['userid'] = $this->getParamList('userid');
        $params['type'] = $this->getParamList('type');

        $params['position'] = trim($this->getParamList('position'));
        $params['robot_position'] = trim($this->getParamList('robot_position'));

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );

        try {
            $id = $this->_model->addRobotPosition($params);
            $result['data']['id'] = $id;
        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }

        $this->echoJson($result);

    }

    public function updatePositionByIdAction()
    {
        $id = intval($this->getParamList('id'));

        $params['userid'] = $this->getParamList('userid');
        $params['type'] = $this->getParamList('type');
        $params['position'] = trim($this->getParamList('position'));
        $params['robot_position'] = trim($this->getParamList('robot_position'));

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );

        try {
            $this->_model->updatePositionById($params, $id);
        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }

        $this->echoJson($result);
    }

    /**
     * Get position list
     */
    public function getPositionListAction()
    {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit'));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['type'] = $this->getParamList('type');
        $data = $this->_model->getPositionList($param);
        $count = $this->_model->getPositionCount($param);
        $data = $this->convertor->getRobotPositionListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }


    /**
     * Get task category list
     */
    public function getTaskCategoryListAction()
    {
        $param = array();
        $param['limit'] = intval($this->getParamList('limit'));
        $param['page'] = intval($this->getParamList('page'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));

        $serviceModel = new ServiceModel();
        $convertor = new Convertor_TaskCategory();
        $data = $serviceModel->getTaskCategoryList($param);
        $count = $serviceModel->getTaskCategoryCount($param);
        $data = $convertor->getTaskCategoryListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * Add a new task category
     */
    public function addTaskCategoryAction()
    {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['parentid'] = intval($this->getParamList('parentid'));
        $param['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param['pic'] = trim($this->getParamList('pic'));

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );
        try {
            $serviceModel = new ServiceModel();
            $lastInsertID = $serviceModel->addTaskCategory($param);
            $result['data']['id'] = $lastInsertID;

        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }
        $this->echoJson($result);


    }

    /**
     * Update task category by ID
     */
    public function updateTaskCategoryAction()
    {

        $param = array();
        $id = intval($this->getParamList('id'));
        $param['parentid'] = $this->getParamList('parentid');
        $param['title_lang1'] = $this->getParamList('title_lang1');
        $param['title_lang2'] = $this->getParamList('title_lang2');
        $param['title_lang3'] = $this->getParamList('title_lang3');
        $param['pic'] = trim($this->getParamList('pic'));

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );

        try {
            $serviceModel = new ServiceModel();
            $serviceModel->updateTaskCategoryById($param, $id);

        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }
        $this->echoJson($result);

    }


    /**
     * Get task list
     */
    public function getTaskListAction()
    {
        $param = array();
        $param['limit'] = intval($this->getParamList('limit'));
        $param['page'] = intval($this->getParamList('page'));
        $param['hotelid'] = $this->getParamList('hotelid');
        $param['category_id'] = $this->getParamList('category_id');
        $param['status'] = $this->getParamList('status');
        $param['id'] = $this->getParamList('id');


        $serviceModel = new ServiceModel();
        $data = $serviceModel->getTaskList($param);
        $count = $serviceModel->getTaskCount($param);

        $convertor = new Convertor_Task();
        $data = $convertor->getTaskListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * Get task order list
     */
    public function getTaskOrderListAction()
    {
        $param = array();
        if (!empty($token)) {
            $params['userid'] = Auth_Login::getToken($token);
            if (empty ($params['userid'])) {
                $this->throwException(3, '登录验证失败');
            }
        } else {
            //keep it for iam website
            $params['userid'] = $this->getParamList('userid');
        }
        $param['limit'] = intval($this->getParamList('limit'));
        $param['page'] = intval($this->getParamList('page'));
        $param['hotelid'] = $this->getParamList('hotelid');
        $param['staff_id'] = $this->getParamList('staff_id');
        $param['admin_id'] = $this->getParamList('admin_id');
        $param['category_id'] = $this->getParamList('category_id');
        $param['department_id'] = $this->getParamList('department_id');
        $param['status'] = $this->getParamList('status');
        $param['id'] = $this->getParamList('id');


        $serviceModel = new ServiceModel();
        $data = $serviceModel->getTaskOrderList($param);
        $count = $serviceModel->getTaskOrderCount($param);

        $convertor = new Convertor_Task();
        $data = $convertor->getTaskOrderListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * Add a new task
     */
    public function addTaskAction()
    {
        $params = array();
        $params['title_lang1'] = $this->getParamList('title_lang1');
        $params['title_lang2'] = $this->getParamList('title_lang2');
        $params['title_lang3'] = $this->getParamList('title_lang3');
        $params['price'] = $this->getParamList('price');
        $params['status'] = $this->getParamList('status');
        $params['category_id'] = $this->getParamList('category_id');
        $params['pic'] = $this->getParamList('pic');

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );
        try {
            $serviceModel = new ServiceModel();
            $lastInsertID = $serviceModel->addTask($params);
            $result['data']['id'] = $lastInsertID;

        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }
        $this->echoJson($result);
    }

    /**
     * Add a new task order
     */
    public function addTaskOrderAction()
    {
        $params = array();
        $token = trim($this->getParamList('token'));

        if (!empty($token)) {
            $params['userid'] = Auth_Login::getToken($token);
            if (empty ($params['userid'])) {
                $this->throwException(3, '登录验证失败');
            }
        } else {
            //keep it for iam website
            $params['userid'] = $this->getParamList('userid');
        }

        $params['room_no'] = $this->getParamList('room_no');
        $params['task_id'] = $this->getParamList('task_id');
        $params['count'] = $this->getParamList('count');
        $params['admin_id'] = $this->getParamList('admin_id');
        $params['memo'] = $this->getParamList('memo');

        $now = time();
        $params['created_at'] = date('Y-m-d H:i:s', $now);
        $params['updated_at'] = date('Y-m-d H:i:s', $now);;

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );
        try {
            $serviceModel = new ServiceModel();
            $lastInsertID = $serviceModel->addTaskOrder($params);
            $serviceModel->sendTaskOrderMsg($lastInsertID, ServiceModel::MSG_TO_STAFF, ServiceModel::MSG_TYPE_EMAIL);
            $serviceModel->sendTaskOrderMsg($lastInsertID, ServiceModel::MSG_TO_STAFF, ServiceModel::MSG_TYPE_APP);

            $result['data']['id'] = $lastInsertID;

        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }
        $this->echoJson($result);
    }


    /**
     * Update task by ID
     */
    public function updateTaskAction()
    {

        $params = array();
        $id = intval($this->getParamList('id'));
        //task info
        $params['title_lang1'] = $this->getParamList('title_lang1');
        $params['title_lang2'] = $this->getParamList('title_lang2');
        $params['title_lang3'] = $this->getParamList('title_lang3');
        $params['price'] = $this->getParamList('price');
        $params['status'] = $this->getParamList('status');
        $params['category_id'] = $this->getParamList('category_id');
        $params['pic'] = $this->getParamList('pic');
        //task process info
        $params['department_id'] = $this->getParamList('department_id');
        $params['staff_id'] = $this->getParamList('staff_id');
        $params['highest_level'] = $this->getParamList('highest_level');
        $params['level_interval_1'] = $this->getParamList('level_interval_1');
        $params['level_interval_2'] = $this->getParamList('level_interval_2');
        $params['level_interval_3'] = $this->getParamList('level_interval_3');
        $params['level_interval_4'] = $this->getParamList('level_interval_4');
        $params['level_interval_5'] = $this->getParamList('level_interval_5');
        $params['sms'] = $this->getParamList('sms');
        $params['email'] = $this->getParamList('email');

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );

        try {
            $serviceModel = new ServiceModel();
            $serviceModel->updateTaskById($params, $id);

        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }
        $this->echoJson($result);

    }


    /**
     * Update task order by ID
     */
    public function updateTaskOrderAction()
    {
        $params = array();
        $id = $this->getParamList('id');
        $params['task_id'] = $this->getParamList('task_id');
        $params['userid'] = $this->getParamList('userid');
        $params['count'] = $this->getParamList('count');
        $params['status'] = $this->getParamList('status');
        $params['admin_id'] = $this->getParamList('admin_id');
        $params['delay'] = $this->getParamList('delay');
        $params['memo'] = $this->getParamList('memo');

        $params['updated_at'] = time();

        $result = array(
            'code' => 0,
            'msg' => "success",
            'data' => array(
                'time' => time()
            )
        );
        try {
            if (!$id) {
                $this->throwException('Lack ID', 1);
            }
            $serviceModel = new ServiceModel();
            $serviceModel->updateTaskOrderById($params, $id);
            $serviceModel->sendTaskOrderMsg($id, ServiceModel::MSG_TO_GUEST);
            $result['data']['id'] = $id;

        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }
        $this->echoJson($result);
    }


    public function orderRemindAction()
    {
        $serviceModel = new ServiceModel();

        $param = array(
            'status' => ServiceModel::TASK_ORDER_OPEN
        );
        $orderList = $serviceModel->getTaskOrderList($param);
        $tsStr = date("Y-H-d H:i:s", time());
        echo "$tsStr Start...\n";
        foreach ($orderList as $order) {
            try {
                $tsStr = date("Y-H-d H:i:s", time());
                echo "$tsStr Process {$order['id']}\n";
                $serviceModel->remindOrder($order);
            } catch (Exception $e) {
                Log_File::writeLog(ServiceModel::LOG_ERROR_FILE, $e->getTraceAsString());
            }
        }
        $tsStr = date("Y-H-d H:i:s", time());
        echo "$tsStr Finished\n";
    }


}
