<?php

class ShareIconController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ShareIconModel();
        $this->convertor = new Convertor_ShareIcon();
    }

    /**
     * 获取ShareIcon列表
     * 
     * @return Json
     */
    public function getShareIconListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getShareIconList($param);
        $data = $this->convertor->getShareIconListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取ShareIcon详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getShareIconDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getShareIconDetail($id);
            $data = $this->convertor->getShareIconDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改ShareIcon信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateShareIconByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateShareIconById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加ShareIcon信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addShareIconAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addShareIcon($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
