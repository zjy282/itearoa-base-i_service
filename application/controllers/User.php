<?php

class UserController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new UserModel();
        $this->convertor = new Convertor_User();
    }

    /**
     * 获取User列表
     * 
     * @return Json
     */
    public function getUserListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getUserList($param);
        $data = $this->convertor->getUserListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取User详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getUserDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getUserDetail($id);
            $data = $this->convertor->getUserDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改User信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateUserByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateUserById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加User信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addUserAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addUser($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
