<?php

class ActivityController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ActivityModel();
        $this->convertor = new Convertor_Activity();
    }

    /**
     * 获取Activity列表
     * 
     * @return Json
     */
    public function getActivityListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getActivityList($param);
        $data = $this->convertor->getActivityListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取Activity详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getActivityDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getActivityDetail($id);
            $data = $this->convertor->getActivityDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Activity信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateActivityByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateActivityById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加Activity信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addActivityAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addActivity($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
