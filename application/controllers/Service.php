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
            if ($e->getMessage() == Enum_ShoppingOrder::EXCEPTION_DIFFERENT_ROOM || $e->getMessage() == Enum_ShoppingOrder::EXCEPTION_HAVE_NO_DEST) {
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


}
