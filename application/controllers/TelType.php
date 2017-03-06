<?php

class TelTypeController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new TelTypeModel();
        $this->convertor = new Convertor_TelType();
    }

    /**
     * 获取TelType列表
     * 
     * @return Json
     */
    public function getTelTypeListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getTelTypeList($param);
        $data = $this->convertor->getTelTypeListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取TelType详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getTelTypeDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getTelTypeDetail($id);
            $data = $this->convertor->getTelTypeDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改TelType信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateTelTypeByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateTelTypeById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加TelType信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addTelTypeAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addTelType($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
