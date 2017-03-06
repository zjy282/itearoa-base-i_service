<?php

class PromotionController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new PromotionModel();
        $this->convertor = new Convertor_Promotion();
    }

    /**
     * 获取Promotion列表
     * 
     * @return Json
     */
    public function getPromotionListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getPromotionList($param);
        $data = $this->convertor->getPromotionListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Promotion详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getPromotionDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getPromotionDetail($id);
            $data = $this->convertor->getPromotionDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Promotion信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updatePromotionByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updatePromotionById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Promotion信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addPromotionAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addPromotion($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
