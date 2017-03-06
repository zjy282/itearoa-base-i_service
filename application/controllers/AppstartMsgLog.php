<?php

class AppstartMsgLogController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new AppstartMsgLogModel();
        $this->convertor = new Convertor_AppstartMsgLog();
    }

    /**
     * 获取AppstartMsgLog列表
     * 
     * @return Json
     */
    public function getAppstartMsgLogListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getAppstartMsgLogList($param);
        $data = $this->convertor->getAppstartMsgLogListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取AppstartMsgLog详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getAppstartMsgLogDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getAppstartMsgLogDetail($id);
            $data = $this->convertor->getAppstartMsgLogDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改AppstartMsgLog信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateAppstartMsgLogByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateAppstartMsgLogById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加AppstartMsgLog信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addAppstartMsgLogAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addAppstartMsgLog($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
