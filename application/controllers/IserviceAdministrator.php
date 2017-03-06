<?php

class IserviceAdministratorController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new IserviceAdministratorModel();
        $this->convertor = new Convertor_IserviceAdministrator();
    }

    /**
     * 获取IserviceAdministrator列表
     * 
     * @return Json
     */
    public function getIserviceAdministratorListAction () {
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->getIserviceAdministratorList($param);
        $data = $this->convertor->getIserviceAdministratorListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取IserviceAdministrator详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getIserviceAdministratorDetailAction () {
        $id = intval($this->_request('id'));
        if ($id){
            $data = $this->model->getIserviceAdministratorDetail($id);
            $data = $this->convertor->getIserviceAdministratorDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改IserviceAdministrator信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateIserviceAdministratorByIdAction(){
        $id = intval($this->_request('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->_request('name'));
            $data = $this->model->updateIserviceAdministratorById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加IserviceAdministrator信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addIserviceAdministratorAction(){
        $param = array ();
        $param['name'] = trim($this->_request('name'));
        $data = $this->model->addIserviceAdministrator($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
