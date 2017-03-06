<?php

class RoomResPicController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new RoomResPicModel();
        $this->convertor = new Convertor_RoomResPic();
    }

    /**
     * 获取RoomResPic列表
     * 
     * @return Json
     */
    public function getRoomResPicListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getRoomResPicList($param);
        $data = $this->convertor->getRoomResPicListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取RoomResPic详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getRoomResPicDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getRoomResPicDetail($id);
            $data = $this->convertor->getRoomResPicDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改RoomResPic信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateRoomResPicByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateRoomResPicById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加RoomResPic信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addRoomResPicAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addRoomResPic($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
