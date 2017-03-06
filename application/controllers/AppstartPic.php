<?php

class AppstartPicController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new AppstartPicModel();
        $this->convertor = new Convertor_AppstartPic();
    }

    /**
     * 获取AppstartPic列表
     * 
     * @return Json
     */
    public function getAppstartPicListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getAppstartPicList($param);
        $data = $this->convertor->getAppstartPicListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取AppstartPic详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getAppstartPicDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getAppstartPicDetail($id);
            $data = $this->convertor->getAppstartPicDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改AppstartPic信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateAppstartPicByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateAppstartPicById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加AppstartPic信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addAppstartPicAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addAppstartPic($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
