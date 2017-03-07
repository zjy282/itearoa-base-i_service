<?php

class ShoppingOrderController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ShoppingOrderModel();
        $this->convertor = new Convertor_ShoppingOrder();
    }

    /**
     * 获取ShoppingOrder列表
     * 
     * @return Json
     */
    public function getShoppingOrderListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getShoppingOrderList($param);
        $data = $this->convertor->getShoppingOrderListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取ShoppingOrder详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getShoppingOrderDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getShoppingOrderDetail($id);
            $data = $this->convertor->getShoppingOrderDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改ShoppingOrder信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateShoppingOrderByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateShoppingOrderById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加ShoppingOrder信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addShoppingOrderAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addShoppingOrder($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
