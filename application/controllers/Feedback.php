<?php

class FeedbackController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new FeedbackModel();
        $this->convertor = new Convertor_Feedback();
    }

    /**
     * 获取Feedback列表
     * 
     * @return Json
     */
    public function getFeedbackListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getFeedbackList($param);
        $data = $this->convertor->getFeedbackListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Feedback详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getFeedbackDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getFeedbackDetail($id);
            $data = $this->convertor->getFeedbackDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Feedback信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateFeedbackByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateFeedbackById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Feedback信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addFeedbackAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addFeedback($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
