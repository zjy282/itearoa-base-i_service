<?php

class RoomController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new RoomModel();
        $this->convertor = new Convertor_Room();
    }

    /**
     * 获取Room列表
     * 
     * @return Json
     */
    public function getRoomListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getRoomList($param);
        $data = $this->convertor->getRoomListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Room详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getRoomDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getRoomDetail($id);
            $data = $this->convertor->getRoomDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Room信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateRoomByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateRoomById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Room信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addRoomAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addRoom($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
