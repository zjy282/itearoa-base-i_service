<?php

class CityController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new CityModel();
        $this->convertor = new Convertor_City();
    }

    /**
     * 获取City列表
     * 
     * @return Json
     */
    public function getCityListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getCityList($param);
        $data = $this->convertor->getCityListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取City详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getCityDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getCityDetail($id);
            $data = $this->convertor->getCityDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改City信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateCityByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateCityById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加City信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addCityAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addCity($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
