<?php

class TrafficController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new TrafficModel();
        $this->convertor = new Convertor_Traffic();
    }

    /**
     * 获取Traffic列表
     * 
     * @return Json
     */
    public function getTrafficListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getTrafficList($param);
        $data = $this->convertor->getTrafficListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Traffic详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getTrafficDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getTrafficDetail($id);
            $data = $this->convertor->getTrafficDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Traffic信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateTrafficByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateTrafficById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Traffic信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addTrafficAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addTraffic($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
