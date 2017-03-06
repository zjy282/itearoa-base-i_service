<?php

class ActivityOrderController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ActivityOrderModel();
        $this->convertor = new Convertor_ActivityOrder();
    }

    /**
     * 获取ActivityOrder列表
     * 
     * @return Json
     */
    public function getActivityOrderListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getActivityOrderList($param);
        $data = $this->convertor->getActivityOrderListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取ActivityOrder详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getActivityOrderDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getActivityOrderDetail($id);
            $data = $this->convertor->getActivityOrderDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改ActivityOrder信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateActivityOrderByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateActivityOrderById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加ActivityOrder信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addActivityOrderAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addActivityOrder($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
