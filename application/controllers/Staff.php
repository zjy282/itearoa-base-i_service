<?php

class StaffController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new StaffModel();
        $this->convertor = new Convertor_Staff();
    }

    /**
     * 获取Staff列表
     *
     * @return Json
     */
    public function getStaffListAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getStaffList($param);
        $data = $this->convertor->getStaffListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取Staff详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getStaffDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getStaffDetail($id);
            $data = $this->convertor->getStaffDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Staff信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateStaffByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateStaffById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Staff信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addStaffAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addStaff($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 登录
     *
     * @param
     *            string lname 员工登录帐号
     * @param
     *            string pwd 员工登录密码
     * @param
     *            int hotelid 物业ID
     * @param
     *            int groupid 集团ID
     * @param
     *            int platform 平台ID
     * @param
     *            string identity 平台标识
     * @return Json
     */
    public function loginAction() {
        $param = array();
        $param['lname'] = trim($this->getParamList('lname'));
        $param['pwd'] = trim($this->getParamList('pwd'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['groupid'] = intval($this->getParamList('groupid'));
        $param['platform'] = intval($this->getParamList('platform'));
        $param['identity'] = trim($this->getParamList('identity'));
        
        $result = $this->model->loginAction($param);
        $result = $this->convertor->userInfoConvertor($result);
        $this->echoSuccessData($result);
    }

    /**
     * 根据Token获取员工信息
     *
     * @param
     *            string token
     * @return Json
     */
    public function getStaffInfoByTokenAction() {
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token, 2);
        if (empty($userId)) {
            $this->throwException(2, 'token验证失败');
        }
        $userInfo = $this->model->getStaffDetail($userId);
        $userInfo['token'] = $token;
        $result = $this->convertor->userInfoConvertor($userInfo);
        $this->echoSuccessData($result);
    }
}
