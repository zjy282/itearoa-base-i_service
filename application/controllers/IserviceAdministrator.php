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
        $param['page'] = intval($this->getParamList('page'));
        $param['limit'] = intval($this->getParamList('limit',5));
        $data = $this->model->getIserviceAdministratorList($param);
        $data = $this->convertor->getIserviceAdministratorListConvertor($data);
        $this->echoSuccessData($data);
    }


    /**
     * 根据id获取IserviceAdministrator详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getIserviceAdministratorDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getIserviceAdministratorDetail($id);
            $data = $this->convertor->getIserviceAdministratorDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改IserviceAdministrator信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateIserviceAdministratorByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            isset($paramList['username']) ? $param['userName'] = trim($paramList['username']) : false;
            isset($paramList['password']) ? $param['password'] = md5(trim($paramList['password'])) : false;
            isset($paramList['realname']) ? $param['realName'] = trim($paramList['realname']) : false;
            isset($paramList['remark']) ? $param['remark'] = trim($paramList['remark']) : false;
            isset($paramList['status']) ? $param['status'] = intval($paramList['status']) : false;
            $data = $this->model->updateIserviceAdministratorById($param,$id); 
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoSuccessData($data);
    }
    
    /**
     * 添加IserviceAdministrator信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addIserviceAdministratorAction(){
        $param['userName'] = trim($this->getParamList('username'));
        $param['password'] = md5(trim($this->getParamList('password')));
        $param['realName'] = trim($this->getParamList('realname'));
        $param['remark'] = trim($this->getParamList('remark'));
        $param['status'] = intval($this->getParamList('status'));
        $param['createTime'] = time();
        $data = $this->model->addIserviceAdministrator($param);
        $data = $this->convertor->statusConvertor(array('id'=>$data));
        $this->echoSuccessData($data);
    }

}
