<?php

class FacilitiesController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new FacilitiesModel();
        $this->convertor = new Convertor_Facilities();
    }

    /**
     * 获取Facilities列表
     * 
     * @return Json
     */
    public function getFacilitiesListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getFacilitiesList($param);
        $data = $this->convertor->getFacilitiesListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Facilities详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getFacilitiesDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getFacilitiesDetail($id);
            $data = $this->convertor->getFacilitiesDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Facilities信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateFacilitiesByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateFacilitiesById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Facilities信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addFacilitiesAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addFacilities($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
