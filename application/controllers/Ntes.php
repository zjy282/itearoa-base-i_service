<?php

/**
 * 网易云信控制器类
 *
 */
class NtesController extends \BaseController {

    /**
     *
     * @var NtesModel
     */
    private $model;

    /**
     *
     * @var Convertor_Ntes
     */
    private $converter;

    public function init() {
        parent::init();
        $this->model = new NtesModel();
        $this->converter = new Convertor_Ntes();
    }

    /**
     * 获取云信Token
     * @throws Exception
     * @author zhangxm
     */
    public function getTokenAction() {
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token, Auth_Login::USER_MARK);
        $tokenData = $this->model->refreshUserToken($userId);
        if ($tokenData["code"]) {
            $this->throwException($tokenData["code"], $tokenData["msg"]);
        }
        $data = $this->converter->getTokenConverter($tokenData['data']);
        $this->echoSuccessData($data);
    }

    /**
     * 禁用云信账号
     * @throws Exception
     * @author zhangxm
     */
    public function logoutAction() {
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token, Auth_Login::USER_MARK);
        $result = $this->model->blockUser($userId);
        if ($result["code"]) {
            $this->throwException($result["code"], $result["msg"]);
        }
        $this->echoSuccessData(array());
    }

    /**
     * 根据用户获取AccId
     * @throws Exception
     * @author zhangxm
     */
    public function getAccIdByUserAction() {
        $param = array();
        $param['room_no'] = trim($this->getParamList('room_no'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['groupid'] = intval($this->getParamList('groupid'));
        if (empty($param['room_no']) || empty($param['hotelid']) || empty($param['groupid'])) {
            $this->throwException(1, '参数错误');
        }
        $userModel = new UserModel();
        $userList = $userModel->getUserList($param);
        $userList = $this->converter->getAccIdByUserConverter($userList);
        $this->echoSuccessData($userList);
    }
}
