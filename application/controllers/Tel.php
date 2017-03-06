<?php

class TelController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new TelModel();
        $this->convertor = new Convertor_Tel();
    }

    /**
     * 获取Tel列表
     * 
     * @return Json
     */
    public function getTelListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getTelList($param);
        $data = $this->convertor->getTelListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Tel详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getTelDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getTelDetail($id);
            $data = $this->convertor->getTelDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Tel信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateTelByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateTelById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Tel信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addTelAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addTel($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
