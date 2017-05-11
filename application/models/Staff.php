<?php

class StaffModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Staff();
    }

    /**
     * 获取Staff列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getStaffList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['staffid'] ? $paramList['staffid'] = $param['staffid'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getStaffList($paramList);
    }

    /**
     * 根据id查询Staff信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getStaffDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getStaffDetail($id);
        }
        return $result;
    }

    /**
     * 根据staffId查询Staff信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getStaffDetailByStaffId($staffId) {
        $result = array();
        if ($staffId) {
            $result = $this->dao->getStaffDetailByStaffId($staffId);
        }
        return $result;
    }

    /**
     * 根据id更新Staff信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateStaffById($param, $id) {
        $result = false;
        if ($id) {
            $info['lname'] = $param['lname'];
            $info['hotelid'] = intval($param['hotelid']);
            $info['groupid'] = intval($param['groupid']);
            $info['lastlogintime'] = time();
            $info['lastloginip'] = Util_Tools::ipton(Util_Http::getIP());
            $info['platform'] = intval($param['platform']);
            $info['identity'] = $param['identity'];
            $result = $this->dao->updateStaffById($info, $id);
        }
        return $result;
    }

    /**
     * Staff新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addStaff($param) {
        $info['lname'] = $param['lname'];
        $info['hotelid'] = intval($param['hotelid']);
        $info['groupid'] = intval($param['groupid']);
        $info['staffid'] = strval($param['staffid']);
        $info['createtime'] = time();
        $info['lastlogintime'] = time();
        $info['lastloginip'] = Util_Tools::ipton(Util_Http::getIP());
        $info['platform'] = intval($param['platform']);
        $info['identity'] = $param['identity'];
        return $this->dao->addStaff($info);
    }

    /**
     * 获取用StaffId信息，跟gsm接口交互
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function getStaffIdInfo($param) {
        $paramList = array();
        $paramList['LType'] = 1;
        $paramList['LName'] = $param['lname'];
        $paramList['Pwd'] = $param['pwd'];
        $paramList = Enum_Gsm::genEncryptGsmParams($paramList);
        $gsmResult = Rpc_Gsm::send(Enum_Gsm::STAFF_LOGIN_METHOD, $paramList);
        return array('staffId' => $gsmResult['StaffID']);
    }

    /**
     * 获取GSM推送的员工地址
     * @param $param
     * @return string
     */
    public function getGsmRedirect($param) {
        $paramList = array();
        $paramList['StaffID'] = $param['StaffID'];
        $paramList = Enum_Gsm::genEncryptGsmParams($paramList);
        $paramList['OrderID'] = $param['OrderID'];

        $url = Rpc_Gsm::makeGsmUrl(Enum_Gsm::STAFF_REDIRECT_METHOD, $paramList);
        return $url;
    }

    /**
     * 登录
     *
     * @param array $param
     * @return array
     */
    public function loginAction($param) {
        if (empty($param['lname']) || empty($param['pwd'])) {
            $this->throwException('登录信息不正确', 2);
        }
        if (empty($param['hotelid']) || empty($param['groupid'])) {
            $this->throwException('酒店集团信息不正确', 3);
        }

        // 获取Oid
        $staffIdInfo = $this->getStaffIdInfo($param);
        if (empty($staffIdInfo['staffId'])) {
            $this->throwException('房间号和名称错误，登录失败', 4);
        }

        // 获取用户信息
        $getStaffInfo = $this->getStaffDetailByStaffId($staffIdInfo['staffId']);
        $userId = $getStaffInfo['id'];

        $newStaffInfo = array(
            'hotelid' => $param['hotelid'],
            'groupid' => $param['groupid'],
            'lname' => $param['lname'],
            'platform' => intval($param['platform']),
            'identity' => trim($param['identity'])
        );

        if ($userId) {
            // 更新用户数据
            if (!$this->updateStaffById($newStaffInfo, $userId)) {
                $this->throwException('登录失败，请重试', 5);
            }
        } else {
            // 新建用户
            $newStaffInfo['staffid'] = $staffIdInfo['staffId'];
            $userId = $this->addStaff($newStaffInfo);
            if (!$userId) {
                $this->throwException('登录失败，请重试', 5);
            }
        }
        $userInfo = $this->getStaffDetail($userId);
        $userInfo['token'] = Auth_Login::makeToken($userId, 2);
        return $userInfo;
    }
}
