<?php

class FeedbackResultController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new FeedbackResultModel();
        $this->convertor = new Convertor_FeedbackResult();
    }

    /**
     * 获取FeedbackResult列表
     * 
     * @return Json
     */
    public function getFeedbackResultListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getFeedbackResultList($param);
        $data = $this->convertor->getFeedbackResultListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取FeedbackResult详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getFeedbackResultDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getFeedbackResultDetail($id);
            $data = $this->convertor->getFeedbackResultDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改FeedbackResult信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateFeedbackResultByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateFeedbackResultById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加FeedbackResult信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addFeedbackResultAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addFeedbackResult($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
