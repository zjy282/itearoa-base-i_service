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
        $target = $this->getParamList('dest');
        try {
            $response = $this->_model->callRobot($target);
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
        $taskId = intval($this->getParamList('taskid'));

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


}
