<?php

class RoomtypeController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new RoomtypeModel();
        $this->convertor = new Convertor_Roomtype();
    }

    /**
     * 获取Roomtype列表
     * 
     * @return Json
     */
    public function getRoomtypeListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getRoomtypeList($param);
        $data = $this->convertor->getRoomtypeListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Roomtype详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getRoomtypeDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getRoomtypeDetail($id);
            $data = $this->convertor->getRoomtypeDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Roomtype信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateRoomtypeByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateRoomtypeById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Roomtype信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addRoomtypeAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addRoomtype($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
