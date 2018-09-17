<?php

/**
 * 酒店入住用户控制器类
 *
 */
class UserController extends \BaseController {

    /**
     *
     * @var UserModel
     */
    private $model;

    /**
     *
     * @var Convertor_User
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new UserModel ();
        $this->convertor = new Convertor_User ();
    }

    /**
     * 获取酒店入住用户列表
     *
     * @return Json
     */
    public function getUserListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['room_no'] = $this->getParamList('room_no');
        $param ['fullname'] = $this->getParamList('fullname');
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['oid'] = $this->getParamList('oid');
        $data = $this->model->getUserList($param);
        $count = $this->model->getUserCount($param);
        $data = $this->convertor->getUserListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店入住用户详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getUserDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getUserDetail($id);
            $data = $this->convertor->getUserDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店入住用户信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateUserByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateUserById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加酒店入住用户信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addUserAction() {
        $param = array();
        $param ['name'] = trim($this->getParamList('name'));
        $data = $this->model->addUser($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 登录
     *
     * @param
     *            string room_no 房间号
     * @param
     *            string fullname 登录姓名
     * @param
     *            int hotelid 物业ID
     * @param
     *            int groupid 集团ID
     * @param
     *            int platform 平台ID
     * @param
     *            string identity 平台标识
     * @param
     *            string lang 语言
     * @return Json
     */
    public function loginAction()
    {
        $param = array();
        $param['token'] = trim($this->getParamList('token'));
        $param['room_no'] = trim($this->getParamList('room_no'));
        $param['fullname'] = trim($this->getParamList('fullname'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['propertyid'] = intval($this->getParamList('propertyinterfId'));
        $param['groupid'] = intval($this->getParamList('groupid'));
        $param['platform'] = intval($this->getParamList('platform'));
        $param['identity'] = trim($this->getParamList('identity'));
        $param['lang'] = trim($this->getParamList('lang'));
        $result = $this->model->loginAction($param);
        $result = $this->convertor->userInfoConvertor($result);
        $this->echoSuccessData($result);
    }

    /**
     * 根据Token获取用户信息
     *
     * @param
     *            string token
     * @return Json
     */
    public function getUserInfoByTokenAction() {
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token);
        if (empty($userId)) {
            $this->throwException(2, 'token验证失败');
        }
        $userInfo = $this->model->getUserDetail($userId);
        $userInfo['token'] = $token;
        $result = $this->convertor->userInfoConvertor($userInfo);
        $this->echoSuccessData($result);
    }

    /**
     * Action for check if pin code already exist
     */
    public function hasPinAction()
    {
        $token = trim($this->getParamList('token'));
        $data = $this->model->checkPin($token);

        $this->echoSuccessData($data);
    }


    public function setPinAction() {
        $params = array();
        $params['token'] = trim($this->getParamList('token'));
        $params['pin'] = trim($this->getParamList('pin'));
        $params['old_pin'] = trim($this->getParamList('old_pin'));

        $data = $this->model->setPin($params);
        $this->echoSuccessData($data);
    }

    public function checkPinAction() {
        $params = array();
        $params['token'] = trim($this->getParamList('token'));
        $params['pin'] = trim($this->getParamList('pin'));

        $data = $this->model->validatePin($params);
        $this->echoSuccessData($data);
    }

    /**
     * 更新用户语言，切换语言的时候调用
     *
     * @param
     *            string token
     * @param
     *            int platform 平台ID
     * @param
     *            string identity 平台标识
     * @param
     *            string lang 语言
     * @return Json
     */
    public function updateUserLangAction() {
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token);
        if (empty ($userId)) {
            $this->throwException(2, 'token验证失败');
        }
        $param = array();
        $param ['platform'] = $this->getParamList('platform');
        $param ['identity'] = $this->getParamList('identity');
        $param ['language'] = $this->getParamList('lang');
        if (empty ($param ['platform']) || empty ($param ['identity']) || empty ($param ['language'])) {
            $this->throwException(3, '入参错误');
        }
        $langNameList = Enum_Lang::getLangNameList();
        if (!$langNameList [$param ['language']]) {
            $this->throwException(5, '暂不支持该语言');
        }
        $result = $this->model->updateUserById($param, $userId);
        if (!$result) {
            $this->throwException(4, '更新失败');
        }
        $userInfo = $this->model->getUserDetail($userId);
        $userInfo ['token'] = $token;
        $result = $this->convertor->userInfoConvertor($userInfo);
        $this->echoSuccessData($result);
    }

    /**
     * Action for sign facilities
     */
    public function signFacilitiesAction()
    {
        $param = array();
        $param['room_no'] = trim($this->getParamList('room_no'));
        $param['fullname'] = trim($this->getParamList('lastname'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['propertyid'] = $this->getParamList('propertyid');
        $param['groupid'] = intval($this->getParamList('groupid'));

        $param ['num'] = intval($this->getParamList('num'));
        $param['lock_no'] = trim($this->getParamList('lock_no'));
        $param['start_time'] = trim($this->getParamList('start_time'));
        $param['end_time'] = trim($this->getParamList('end_time'));
        $param['time'] = intval($this->getParamList('time'));
        $param['type'] = trim($this->getParamList('type'));
        $param['sports'] = trim($this->getParamList('sports'));

        $result = $this->model->signFacilities($param);
        $this->echoJson($result);
    }


    public function getTokenAction()
    {
        $params = array();
        $token = trim($this->getParamList('token'));
        $params['type'] = strtolower(trim($this->getParamList('type')));

        try {
            $params['userid'] = intval(Auth_Login::getToken($token));
            $result = $this->model->getToken($params);
            $result = array(
                'code' => 0,
                'msg' => 'success',
                'data' => $result
            );
        } catch (Exception $e) {
            Log_File::writeLog('Token', $e->getMessage() . "\n" . $e->getTraceAsString());
            $msg = $e->getMessage();
            $result = array(
                'code' => $e->getCode(),
                'msg' => $msg,
                'data' => array()
            );
        }

        $this->echoJson($result);
    }

    /**
     * Action for shopping box token generation
     */
    public function getShoppingBoxDetailAction()
    {
        $token = trim($this->getParamList('token'));

        try {
            $userid = intval(Auth_Login::getToken($token));
            if ($userid <= 0) {
                $staffId = intval(Auth_Login::getToken($token, Auth_Login::STAFF_MARK));
                $result = $this->model->getShoppingBoxTokenStaff($staffId);
            } else {
                $result = $this->model->getShoppingBoxToken($userid);
            }
            $result = array(
                'code' => 0,
                'msg' => 'success',
                'data' => $result
            );
        } catch (Exception $e) {
            Log_File::writeLog('Token', $e->getMessage() . "\n" . $e->getTraceAsString());
            $msg = $e->getMessage();
            $result = array(
                'code' => $e->getCode(),
                'msg' => $msg,
                'data' => array()
            );
        }

        $this->echoJson($result);
    }

}
