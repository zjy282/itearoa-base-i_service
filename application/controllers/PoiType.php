<?php

class PoiTypeController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new PoiTypeModel();
        $this->convertor = new Convertor_PoiType();
    }

    /**
     * 获取PoiType列表
     * 
     * @return Json
     */
    public function getPoiTypeListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getPoiTypeList($param);
        $data = $this->convertor->getPoiTypeListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取PoiType详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getPoiTypeDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getPoiTypeDetail($id);
            $data = $this->convertor->getPoiTypeDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改PoiType信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updatePoiTypeByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updatePoiTypeById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加PoiType信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addPoiTypeAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addPoiType($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
