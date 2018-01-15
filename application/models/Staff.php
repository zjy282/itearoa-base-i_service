<?php

/**
 * Class StaffModel
 * 员工管理
 */
class StaffModel extends \BaseModel
{

    const STAFF_WEB_IDENTIFY = 'staff_login_from_web';
    const STAFF_ID_PREFIX = 'iService';


    const GROUP_LOGIN_SERVICE = array(
        2,
    );

    private $dao;

    public function __construct()
    {
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
    public function getStaffList(array $param)
    {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['staffid'] ? $paramList['staffid'] = $param['staffid'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = $param['hotelid'] : false;
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
    public function getStaffDetail($id)
    {
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
    public function getStaffDetailByStaffId($staffId)
    {
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
    public function updateStaffById($param, $id)
    {
        $result = false;
        if ($id) {
            $param['lname'] ? $info['lname'] = $param['lname'] : false;
            intval($param['hotelid']) ? $info['hotelid'] = intval($param['hotelid']) : false;
            intval($param['groupid']) ? $info['groupid'] = intval($param['groupid']) : false;
            $info['lastlogintime'] = time();
            $info['lastloginip'] = Util_Tools::ipton(Util_Http::getIP());
            intval($param['platform']) ? $info['platform'] = intval($param['platform']) : false;
            $param['identity'] ? $info['identity'] = $param['identity'] : false;
            $param['staff_web_hotel_id'] ? $info['staff_web_hotel_id'] = intval($param['staff_web_hotel_id']) : false;
            $param['admin_id'] ? $info['admin_id'] = intval($param['admin_id']) : false;
            $result = $this->dao->updateStaffById($info, $id);
        }
        return $result;
    }

    /**
     * Staff新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return int
     */
    public function addStaff($param)
    {
        $info['lname'] = $param['lname'];
        $info['hotelid'] = intval($param['hotelid']);
        $info['groupid'] = intval($param['groupid']);
        $info['staffid'] = strval($param['staffid']);
        $info['createtime'] = time();
        $info['lastlogintime'] = time();
        $info['lastloginip'] = Util_Tools::ipton(Util_Http::getIP());
        $info['platform'] = intval($param['platform']);
        $info['identity'] = $param['identity'];
        $info['admin_id'] = intval('admin_id');
        return $this->dao->addStaff($info);
    }

    /**
     * 获取用StaffId信息，跟gsm接口交互
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function getStaffIdInfo($param)
    {
        $paramList = array();
        if (in_array($param['groupid'], self::GROUP_LOGIN_SERVICE)) {
            $staffId = $this->_loginWithService($param);
        } else {
            $paramList['LType'] = intval($param['isAd']);
            $paramList['LName'] = $param['lname'];
            $paramList['Pwd'] = $param['pwd'];
            $paramList = Enum_Gsm::genEncryptGsmParams($paramList);
            $gsmResult = Rpc_Gsm::send(Enum_Gsm::STAFF_LOGIN_METHOD, $paramList);
            $staffId = $gsmResult['StaffID'];
        }

        return array('staffId' => $staffId);
    }

    /**
     * 获取GSM推送的员工地址
     * @param $param
     * @return string
     */
    public function getGsmRedirect($param)
    {
        $paramList = array();
        $paramList['StaffID'] = $param['StaffID'];
        $paramList = Enum_Gsm::genEncryptGsmParams($paramList);
        $paramList['OrderID'] = $param['OrderID'];

        $url = Rpc_Gsm::makeGsmUrl(Enum_Gsm::STAFF_REDIRECT_METHOD, $paramList);
        return $url;
    }

    /**
     * 员工登录
     *
     * @param array $param
     * @return array
     */
    public function loginAction($param)
    {
        if (empty($param['lname']) || empty($param['pwd'])) {
            $this->throwException('登录信息不正确', 2);
        }
        if (empty($param['hotelid']) || empty($param['groupid'])) {
            //hotel and group are not necessary when login from staff web
            if ($param['identity'] != self::STAFF_WEB_IDENTIFY) {
                $this->throwException('酒店集团信息不正确', 3);
            }
        }

        // 获取Oid
        $staffIdInfo = $this->getStaffIdInfo($param);
        if (empty($staffIdInfo['staffId'])) {
            $this->throwException('账号密码错误，登录失败', 4);
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

        $isStaffWeb = ($newStaffInfo['identity'] == self::STAFF_WEB_IDENTIFY);
        if ($isStaffWeb) {
            $newStaffInfo['platform'] = $getStaffInfo['platform'];
        }
        $newStaffInfo['admin_id'] = $this->getAdminId(intval($newStaffInfo['groupid']), $staffIdInfo['staffId']);
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
        if (!$isStaffWeb) {
            $userInfo['token'] = Auth_Login::makeToken($userId, 2);
        }
        return $userInfo;
    }

    /**
     * Staff login with iService auth
     *
     * @param $param
     * @return string
     */
    private function _loginWithService($param)
    {

        $paramList['username'] = $param['lname'];
        $paramList['password'] = $param['pwd'];

        if (empty($param['lname']) || empty($param['pwd'])) {
            $this->throwException('登录信息不正确', 2);
        }
        if (empty($param['hotelid']) || empty($param['groupid'])) {
            //hotel and group are not necessary when login from staff web
            if ($param['identity'] != self::STAFF_WEB_IDENTIFY) {
                $this->throwException('酒店集团信息不正确', 3);
            }
        }

        $daoAdmin = new Dao_HotelAdministrator();
        $admin = $daoAdmin->getHotelAdministratorDetailByUsername($paramList['username']);
        if (!$admin || $admin['password'] != md5(Enum_Login::getMd5Pass($paramList['password']))) {
            $this->throwException('账号密码错误，登录失败', 4);
        }
        $staffId = $this->_getStaffId($param['hotelid'], $admin['id']);
        return $staffId;
    }

    /**
     * @param int $hotelid
     * @return string
     */
    private function _getStaffId(int $hotelid, int $userId): string
    {
        return self::STAFF_ID_PREFIX . '_' . $hotelid . '_' . $userId;
    }

    /**
     * Extract admin id from staffid
     *
     * @param string $staffId
     * @return int
     */
    public function getAdminId(int $groupId, string $staffId): int
    {
        if(!in_array($groupId, self::GROUP_LOGIN_SERVICE)){
            return 0;
        }
        preg_match('/_(\d+)$/', $staffId, $matches);
        if (count($matches) != 2) {
            $this->throwException('StaffId format error', 1);
        }
        return intval($matches[2]);
    }
}
