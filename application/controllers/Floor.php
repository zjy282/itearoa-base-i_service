<?php

class FloorController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new FloorModel();
        $this->convertor = new Convertor_Floor();
    }

    /**
     * 获取Floor列表
     * 
     * @return Json
     */
    public function getFloorListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getFloorList($param);
        $data = $this->convertor->getFloorListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Floor详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getFloorDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getFloorDetail($id);
            $data = $this->convertor->getFloorDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Floor信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateFloorByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateFloorById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Floor信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addFloorAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addFloor($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
