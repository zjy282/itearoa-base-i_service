<?php

class RoomResController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new RoomResModel();
        $this->convertor = new Convertor_RoomRes();
    }

    /**
     * 获取RoomRes列表
     * 
     * @return Json
     */
    public function getRoomResListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getRoomResList($param);
        $data = $this->convertor->getRoomResListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取RoomRes详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getRoomResDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getRoomResDetail($id);
            $data = $this->convertor->getRoomResDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改RoomRes信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateRoomResByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateRoomResById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加RoomRes信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addRoomResAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addRoomRes($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
