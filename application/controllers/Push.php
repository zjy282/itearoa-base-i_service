<?php

class PushController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new PushModel();
        $this->convertor = new Convertor_Push();
    }

    /**
     * 获取Push列表
     * 
     * @return Json
     */
    public function getPushListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getPushList($param);
        $data = $this->convertor->getPushListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Push详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getPushDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getPushDetail($id);
            $data = $this->convertor->getPushDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Push信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updatePushByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updatePushById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Push信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addPushAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addPush($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
