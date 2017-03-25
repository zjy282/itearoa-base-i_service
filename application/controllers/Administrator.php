<?php
/**
 * 集团管理员控制器类
 */
class AdministratorController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new AdministratorModel();
        $this->convertor = new Convertor_Administrator();
    }

    /**
     * 获取Administrator列表
     * 
     * @return Json
     */
    public function getAdministratorListAction () {
        $param = array ();
        $param['page'] = intval($this->getParamList('page'));
        $param['limit'] = intval($this->getParamList('limit',5));
        $data = $this->model->getAdministratorList($param);
        $data = $this->convertor->getAdministratorListConvertor($data);
        $this->echoSuccessData($data);
    }


    /**
     * 根据id获取Administrator详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getAdministratorDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getAdministratorDetail($id);
            $data = $this->convertor->getAdministratorDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改Administrator信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateAdministratorByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            isset($paramList['username']) ? $param['userName'] = trim($paramList['username']) : false;
            isset($paramList['password']) ? $param['password'] = md5(trim($paramList['password'])) : false;
            isset($paramList['realname']) ? $param['realName'] = trim($paramList['realname']) : false;
            isset($paramList['remark']) ? $param['remark'] = trim($paramList['remark']) : false;
            isset($paramList['status']) ? $param['status'] = intval($paramList['status']) : false;
            isset($paramList['groupid']) ? $param['groupId'] = trim($paramList['groupid']) : false;
            $data = $this->model->updateAdministratorById($param,$id); 
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoSuccessData($data);
    }
    
    /**
     * 添加Administrator信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addAdministratorAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addAdministrator($param);
        $data = $this->convertor->statusConvertor($data);
        $this->echoSuccessData($data);
    }

}
