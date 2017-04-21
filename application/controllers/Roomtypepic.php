<?php

class RoomtypePicController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new RoomtypePicModel();
        $this->convertor = new Convertor_RoomtypePic();
    }

    /**
     * 获取RoomtypePic列表
     * 
     * @return Json
     */
    public function getRoomtypePicListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getRoomtypePicList($param);
        $data = $this->convertor->getRoomtypePicListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取RoomtypePic详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getRoomtypePicDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getRoomtypePicDetail($id);
            $data = $this->convertor->getRoomtypePicDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改RoomtypePic信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateRoomtypePicByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateRoomtypePicById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加RoomtypePic信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addRoomtypePicAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addRoomtypePic($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
