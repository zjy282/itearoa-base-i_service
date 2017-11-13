<?php

/**
 * Controller for service
 *
 */
class ServiceController extends \BaseController
{

    /**
     *
     * @var ShoppingModel
     */
    private $model;

    /**
     *
     * @var Convertor_Shopping
     */
    private $convertor;

    public function init()
    {
        parent::init();
        $this->model = new ShoppingModel ();
        $this->convertor = new Convertor_Shopping ();
    }


    public function callRobotAction()
    {
        $target = $this->getParamList('dest');
        try {
            $shoppingOrderModel = new ShoppingOrderModel();
            $response = $shoppingOrderModel->callRobot($target);
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
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['userid'] = $this->getParamList('userid');
        $params['start'] = $this->getParamList('start');
        $params['itemlist'] = json_decode($this->getParamList('itemlist'), true);
        $params['time'] = $this->getParamList('time', time());

        try {
            $shoppingOrderModel = new ShoppingOrderModel();
            $result = $shoppingOrderModel->robotDeliver($params);
        } catch (Exception $e) {
            Log_File::writeLog('robotShopping', $e->getMessage() . "\n" . $e->getTraceAsString());
            if ($e->getMessage() == Enum_ShoppingOrder::EXCEPTION_DIFFERENT_ROOM) {
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


}
