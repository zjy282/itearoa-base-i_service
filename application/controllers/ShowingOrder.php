<?php

class ShowingOrderController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ShowingOrderModel();
        $this->convertor = new Convertor_ShowingOrder();
    }

    /**
     * 获取ShowingOrder列表
     * 
     * @return Json
     */
    public function getShowingOrderListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getShowingOrderList($param);
        $data = $this->convertor->getShowingOrderListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取ShowingOrder详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getShowingOrderDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getShowingOrderDetail($id);
            $data = $this->convertor->getShowingOrderDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改ShowingOrder信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateShowingOrderByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateShowingOrderById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加ShowingOrder信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addShowingOrderAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addShowingOrder($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
