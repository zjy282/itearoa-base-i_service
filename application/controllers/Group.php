<?php

class GroupController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new GroupModel();
        $this->convertor = new Convertor_Group();
    }

    /**
     * 获取<class_name>列表
     * 
     * @return Json
     */
    public function getGroupListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getGroupList($param);
        $data = $this->convertor->getGroupListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取<class_name>详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getGroupDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getGroupDetail($id);
            $data = $this->convertor->getGroupDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改<class_name>信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateGroupbyIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateGroupById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加<class_name>信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addGroupAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addGroup($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
