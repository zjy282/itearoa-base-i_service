<?php

class IserviceFeedbackController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new IserviceFeedbackModel();
        $this->convertor = new Convertor_IserviceFeedback();
    }

    /**
     * 获取IserviceFeedback列表
     * 
     * @return Json
     */
    public function getIserviceFeedbackListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getIserviceFeedbackList($param);
        $data = $this->convertor->getIserviceFeedbackListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取IserviceFeedback详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getIserviceFeedbackDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getIserviceFeedbackDetail($id);
            $data = $this->convertor->getIserviceFeedbackDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改IserviceFeedback信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateIserviceFeedbackByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateIserviceFeedbackById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加IserviceFeedback信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addIserviceFeedbackAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addIserviceFeedback($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
