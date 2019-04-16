<?php

use Frankli\Itearoa\Models\User;
use Frankli\Itearoa\Models\Staff;
use Frankli\Itearoa\Models\Config;

/**
 * Class UserModel
 * APP用户管理
 */
class UserModel extends \BaseModel
{

    const STAFF_ROOM_ID = '001';

    private $dao;

    public function __construct()
    {
        parent::__construct();
        $this->dao = new Dao_User();
    }

    /**
     * 获取User列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getUserList(array $param)
    {
        $param['oid'] ? $paramList['oid'] = $param['oid'] : false;
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['room_no'] ? $paramList['room_no'] = $param['room_no'] : false;
        $param['fullname'] ? $paramList['fullname'] = $param['fullname'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = $param['hotelid'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getUserList($paramList);
    }

    /**
     * 获取User数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getUserCount(array $param)
    {
        $paramList = array();
        isset($param['oid']) ? $paramList['oid'] = trim($param['oid']) : false;
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['room_no'] ? $paramList['room_no'] = $param['room_no'] : false;
        $param['fullname'] ? $paramList['fullname'] = $param['fullname'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = $param['hotelid'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        return $this->dao->getUserCount($paramList);
    }

    /**
     * 根据id查询User信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getUserDetail($id)
    {
        $result = array();
        if ($id) {
            $result = $this->dao->getUserDetail($id);
        }
        return $result;
    }

    /**
     * 根据oid查询User信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getUserDetailByOId($oid)
    {
        $result = array();
        if ($oid) {
            $result = $this->dao->getUserDetailByOId($oid);
        }
        return $result;
    }

    /**
     * 根据id更新User信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateUserById($param, $id)
    {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            is_null($param['room_no']) ? false : $info['room_no'] = $param['room_no'];
            is_null($param['hotelid']) ? false : $info['hotelid'] = intval($param['hotelid']);
            is_null($param['groupid']) ? false : $info['groupid'] = intval($param['groupid']);
            is_null($param['fullname']) ? false : $info['fullname'] = trim($param['fullname']);
            is_null($param['platform']) ? false : $info['platform'] = trim($param['platform']);
            is_null($param['identity']) ? false : $info['identity'] = trim($param['identity']);
            is_null($param['language']) ? false : $info['language'] = trim($param['language']);

            $info['lastlogintime'] = time();
            $info['lastloginip'] = Util_Tools::ipton(Util_Http::getIP());
            $result = $this->dao->updateUserById($info, $id);
        }
        return $result;
    }

    /**
     * User新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addUser($param)
    {
        $info['room_no'] = $param['room_no'];
        $info['hotelid'] = intval($param['hotelid']);
        $info['groupid'] = intval($param['groupid']);
        $info['oid'] = strval($param['oid']);
        $info['fullname'] = strval($param['fullname']);
        $info['createtime'] = time();
        $info['lastlogintime'] = time();
        $info['lastloginip'] = Util_Tools::ipton(Util_Http::getIP());
        $info['platform'] = intval($param['platform']);
        $info['identity'] = $param['identity'];
        $info['language'] = $param['language'];
        return $this->dao->addUser($info);
    }

    /**
     * 获取用Oid信息，跟gsm接口交互
     *
     * @param $param
     * @return array
     */
    public function getOIdInfo($param)
    {
        $paramList = array();
        if ($param['propertyid'] <= 0 || is_null($param['groupid'])) {
            $hotelModel = new HotelListModel();
            $hotelInfo = $hotelModel->getHotelListDetail($param['hotelid']);
            $paramList['PropertyInterfID'] = $hotelInfo['propertyinterfid'];
            $param['groupid'] = intval($hotelInfo['groupid']);
        } else {
            $paramList['PropertyInterfID'] = $param['propertyid'];
        }

        $paramList['Room'] = $param['room_no'];
        $paramList['LastName'] = $param['fullname'];
        $paramList = Enum_Gsm::genEncryptGsmParams($paramList);
        $gsmResult = Rpc_Gsm::send(Enum_Gsm::getUserLoginUrl($param['groupid']), $paramList);
        return array(
            'oId' => $gsmResult['OID'],
            'room' => $gsmResult['Room'],
            'fullName' => $gsmResult['FullName']
        );
    }

    /**
     * 获取GSM推送的用户地址
     * @param $param
     * @return string
     */
    public function getGsmRedirect($param)
    {
        $paramList = array();
        $paramList['PropertyInterfID'] = $param['PropertyInterfID'];
        $paramList['CustomerID'] = $param['CustomerID'];
        $paramList['Room'] = $param['Room'];
        $paramList['LastName'] = $param['LastName'];
        $paramList = Enum_Gsm::genEncryptGsmParams($paramList);
        $paramList['OrderID'] = $param['OrderID'];

        $url = Rpc_Gsm::makeGsmUrl(Enum_Gsm::getUserRedirectUrl($param['groupid']), $paramList);
        return $url;
    }


    /**
     * 用户登录
     *
     * @param array $param
     * @return array
     */
    public function loginAction($param)
    {
        //check if token is expired
//        if (!empty($param['token'])) {
//            $userId = Auth_Login::getToken($param['token']);
//            if ($userId > 0) {
//                $userInfo = $this->getUserDetail($userId);
//                $userInfo['token'] = $param['token'];
//                $userInfo['room_response'] = $userInfo['room'];
//                $userInfo['lastname_response'] = $userInfo['fullName'];
//                return $userInfo;
//            }
//        }

        if (empty($param['room_no']) || empty($param['fullname'])) {
            $this->throwException('登录信息不正确', 2);
        }
        if (empty($param['hotelid']) || empty($param['groupid'])) {
            $this->throwException('酒店集团信息不正确', 3);
        }

        if ($param['lang']) {
            $langNameList = Enum_Lang::getLangNameList();
            if (!$langNameList[$param['lang']]) {
                $this->throwException('暂不支持该语言', 6);
            }
        }

        // 获取Oid
        $oIdInfo = $this->getOIdInfo($param);
        if (empty($oIdInfo['oId']) || $oIdInfo['oId'] < 0) {
            $this->throwException('房间号和名称错误，登录失败', 4);
        }

        // 获取用户信息
        $getUserInfo = $this->getUserDetailByOId($oIdInfo['oId']);
        $userId = $getUserInfo['id'];

        $newUserInfo = array(
            'hotelid' => $param['hotelid'],
            'groupid' => $param['groupid'],
            'room_no' => $param['room_no'],
            'fullname' => $param['fullname'],
            'identity' => trim($param['identity']),
            'language' => trim($param['lang'])
        );

        if ($param['platform'] > 0) {
            // update the platform only it come from mobile
            $newUserInfo['platform'] = intval($param['platform']);
        }

        // 入住记录数据
        $userHistoryModel = new UserHistoryModel();
        $historyInfo = array(
            'hotelid' => $param['hotelid'],
            'groupid' => $param['groupid']
        );
        if ($userId) {
            // 更新用户数据
            if (!$this->updateUserById($newUserInfo, $userId)) {
                $this->throwException('登录失败，请重试', 5);
            }
            if ($param['hotelid'] != $getUserInfo['hotelid']) {
                $historyInfo['userid'] = $userId;
                $userHistoryModel->addUserHistory($historyInfo);
            }
        } else {
            // 新建用户
            $newUserInfo['oid'] = $oIdInfo['oId'];
            $userId = $this->addUser($newUserInfo);
            if (!$userId) {
                $this->throwException('登录失败，请重试', 5);
            }
            $historyInfo['userid'] = $userId;
            $userHistoryModel->addUserHistory($historyInfo);
        }
        $userInfo = $this->getUserDetail($userId);
        $timeout = intval(Yaf_Registry::get('sysConfig')['auth.timeout']) > 0 ? intval(Yaf_Registry::get('sysConfig')['auth.timeout']) : 3600;
        $userInfo['token'] = Auth_Login::makeToken($userId, Auth_Login::USER_MARK, $timeout);
        $userInfo['room_response'] = $oIdInfo['room'];
        $userInfo['lastname_response'] = $oIdInfo['fullName'];
        return $userInfo;
    }


    /**
     * sign facilities
     *
     * @param array $params
     * @return array
     */
    public function signFacilities(array $params)
    {
        $result = array(
            'code' => 0,
            'msg' => 'success'
        );
        $dao = new Dao_Sign();
        $hotelModel = new HotelListModel();
        $hotelInfo = $hotelModel->getHotelListDetail($params['hotelid']);
        $params['groupid'] = intval($hotelInfo['groupid']);
        try {
            $oIdInfo = $this->getOIdInfo($params);
            if (empty($oIdInfo['oId']) || $oIdInfo['oId'] < 0) {
                $this->throwException('房间号和名称错误，登录失败', 4);
            }
            $getUserInfo = $this->getUserDetailByOId($oIdInfo['oId']);
            $userId = $getUserInfo['id'];
            if (!$userId) {
                $userInfo = array(
                    'hotelid' => $params['hotelid'],
                    'groupid' => $params['groupid'],
                    'room_no' => $params['room_no'],
                    'fullname' => $params['lastname'],
                    'identity' => '',
                    'language' => 'zh',
                    'oid' => $oIdInfo['oId'],
                );
                $userId = $this->addUser($userInfo);
                if (!$userId) {
                    $this->throwException('登录失败，请重试', 5);
                }
            } else {
                $userInfo = array(
                    'hotelid' => $params['hotelid'],
                    'groupid' => $params['groupid'],
                    'room_no' => $params['room_no'],
                    'fullname' => $params['lastname'],
                );
                $this->updateUserById($userInfo, $userId);
            }
            $info = array(
                'userid' => $userId,
                'type' => $params['type'],
                'room_no' => $params['room_no'],
                'lastname' => $params['fullname'],
                'hotelid' => $params['hotelid'],
                'groupid' => $params['groupid'],
                'lock_no' => $params['lock_no'],
                'num' => $params['num'],
                'sports' => $params['sports'],
                'start_time' => $params['start_time'],
                'end_time' => $params['end_time'],
                'created_at' => date('Y-m-d H:i:s', $params['time']),
            );
            if (!is_null($params['propertyid'])) {
                $info['propertyid'] = intval($params['propertyid']);
            } else {
                $info['propertyid'] = intval($hotelInfo['propertyinterfid']);
            }
            $lastInsertId = $dao->addSign($info);
            $result['msg'] = $lastInsertId;
        } catch (Exception $e) {
            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Magic method for get token
     *
     * @param $params
     * @return mixed
     */
    public function getToken($params)
    {
        $method = __FUNCTION__ . ucfirst($params['type']);
        if ($params['userid'] <= 0) {
            $this->throwException('Token expired, please login before get token', Enum_Login::EXCEPTION_CODE_EXPIRED);
        }
        if (empty($params['type']) || !method_exists($this, $method)) {
            $this->throwException('Type not support' . "[${params['type']}]", 1);
        } else {
            return call_user_func(array($this, $method), $params);
        }
    }


    /**
     * Sub method for getToken
     *
     * @param $params
     * @return string
     */
    protected function getTokenBreakfast($params)
    {
        $seedConfig = Yaf_Registry::get('sysConfig')['token']['seed'][$params['type']];
        $userDao = new Dao_User();
        $hotelDao = new Dao_HotelList();

        $userDetail = $userDao->getUserDetail($params['userid']);
        $hotelid = intval($userDetail['hotelid']);
        if ($hotelid <= 0) {
            $this->throwException('User not login', 1);
        }

        $hotelDetail = $hotelDao->getHotelListDetail($hotelid);
        $propertyId = intval($hotelDetail['propertyinterfid']);
        if ($propertyId <= 0) {
            $this->throwException('Property ID not configured for hotel:' . $hotelid, 1);
        }


        if (!empty(trim($seedConfig[$hotelid]))) {
            $seed = $seedConfig[$hotelid];
        } else {
            $seed = $seedConfig['default'];
        }
        $date = date('Y-m-d', time());
        if($propertyId==2){
            $seed = 'arcc';
        }
        $string = sprintf("PorpertyID=%s&Room=%s&OID=%s&Time=%s&VerifyCode=%s",
            $propertyId, $userDetail['room_no'], $userDetail['oid'], $date,
            md5($propertyId . $userDetail['room_no'] . $userDetail['oid'] . $date . $seed));

        return $string;

    }

    /**
     * Check if pin is set
     *
     * @param $token
     * @throws Exception
     */
    public function checkPin($token)
    {
        $userId = Auth_Login::getToken($token);
        if (empty($userId)) {
            $this->throwException('token expired', 2);
        }
        $user = User::find($userId);
        if (is_null($user)) {
            $this->throwException('token expired', 2);
        }
        if (empty($user->pin_code)) {
            $this->throwException('pin is empty', 1);
        }
    }

    /**
     * User set or reset pin
     *
     * @param array $params
     * @throws Exception
     * @return int
     */
    public function setPin(array $params): int
    {
        $userId = Auth_Login::getToken($params['token']);
        if (empty($userId)) {
            $this->throwException('token验证失败', 1);
        }

        if (!preg_match('/^[0-9]{6}$/', $params['pin'])) {
            $this->throwException('Pin should be 6 digit', 2);
        }

        $user = User::find($userId);
        if (is_null($user)) {
            $this->throwException('token验证失败', 2);
        }
        if (!empty($user->pin_code)) {
            if (empty($params['old_pin'])) {
                $this->throwException('密码已设置，重置密码请联系前台', 3);
            }
            //pass old_pin if reset
            if (self::encodePwd($params['old_pin']) != $user->pin_code) {
                $this->throwException('密码输入错误，忘记密码请联系前台重置', 4);
            }
        }

        $pinCode = self::encodePwd($params['pin']);
        $user->pin_code = $pinCode;
        $saved = $user->save();
        if (!$saved) {
            $this->throwException('系统错误，请重试', 5);
        }
        return $user->id;
    }

    /**
     * Staff help user reset the pin code
     *
     * @param array $params
     * @throws Exception
     * @return bool
     */
    public function staffResetPin(array $params): bool
    {
        $staffId = Auth_Login::getToken($params['token'], 2);
        if ($staffId <= 0) {
            $this->throwException('员工登录过期，请重新登录', 1);
        }
        $staffDao = new Dao_Staff();
        $staffInfo = $staffDao->getStaffDetail($staffId);
        $user = User::find($params['userid']);
        if (empty($staffInfo) || !$user || ($user->hotelid != $staffInfo['hotelid'])) {
            $this->throwException('Staff not match with userid', 2);
        }

        if (!empty($user->pin_code)) {
            $user->pin_code = '';
            $saved = $user->save();
        } else {
            $saved = true;
        }

        if (!$saved) {
            $this->throwException('系统错误，请重试', 3);
        }
        return true;
    }

    public function notifyResetPin(int $userId, int $staff) {

    }


    /**
     * @param array $params
     * @return bool
     */
    public function validatePin(array $params): bool
    {
        $userId = Auth_Login::getToken($params['token']);
        if (empty($userId)) {
            $this->throwException('token验证失败', 1);
        }
        $user = User::find($userId);
        if (is_null($user)) {
            $this->throwException('token验证失败', 1);
        }
        if (empty($user->pin_code)) {
            $this->throwException('Pin is empty', 3);
        }
        if ($user->pin_code != self::encodePwd($params['pin'])) {
            $this->throwException('Pin incorrect', 2);
        }
        return $user->id;
    }

    /**
     * Encode pin code with salt
     *
     * @param string $pin
     * @return string
     */
    public static function encodePwd(string $pin): string
    {
        $sysConfig = Yaf_Registry::get('sysConfig');
        return md5($sysConfig->service->salt . strval($pin));
    }

    /**
     * Get shopping box token
     *
     * @param int $userid
     * @return array
     */
    public function getShoppingBoxToken(int $userid): array
    {
        if ($userid <= 0) {
            $this->throwException('Token验证失败，请重新登录', Enum_Login::EXCEPTION_CODE_EXPIRED);
        }
        $user = User::find($userid);
        if (is_null($user)) {
            $this->throwException('token验证失败，请重新登录', Enum_Login::EXCEPTION_CODE_EXPIRED);
        }
        $names = ['shopping_box_storid', 'shopping_box_accountid', 'shopping_box_salt'];
        $items = Config::where('hotelid', $user->hotelid)->whereIn('name', $names)->get();
        if (count($items) != count($names)) {
            $this->throwException('参数不全' . json_encode($names), 1);
        }
        $config = array();
        foreach ($items as $item) {
            $config[$item->name] = $item->value;
        }
        $result = array(
            'storeId' => $config['shopping_box_storid'],
            'roomId' => ltrim($user->room_no, '0'),
            'name' => $user->fullname,
            'date' => date('Y-m-d')
        );
        if (!empty($config['shopping_box_accountid'])) {
            $result['accountsId'] = $config['shopping_box_accountid'];
        }
        $result['verifyCode'] = md5($result['storeId'] . $result['roomId'] .
            $result['name'] . $result['date'] . $config['shopping_box_salt']);
        return $result;

    }

    /**
     * Get shopping box token for staff
     *
     * @param int $userid
     * @return array
     */
    public function getShoppingBoxTokenStaff(int $staffId): array
    {
        if ($staffId <= 0) {
            $this->throwException('Token验证失败，请重新登录', Enum_Login::EXCEPTION_CODE_EXPIRED);
        }
        $staff = Staff::find($staffId);
        if (is_null($staff)) {
            $this->throwException('token验证失败，请重新登录', Enum_Login::EXCEPTION_CODE_EXPIRED);
        }
        $names = ['shopping_box_storid', 'shopping_box_accountid', 'shopping_box_salt'];
        $items = Config::where('hotelid', $staff->hotelid)->whereIn('name', $names)->get();
        if (count($items) != count($names)) {
            $this->throwException('参数不全' . json_encode($names), 1);
        }
        $config = array();
        foreach ($items as $item) {
            $config[$item->name] = $item->value;
        }
        $result = array(
            'storeId' => $config['shopping_box_storid'],
            'roomId' => self::STAFF_ROOM_ID,
            'name' => $staff->lname,
            'date' => date('Y-m-d')
        );
        if (!empty($config['shopping_box_accountid'])) {
            $result['accountsId'] = $config['shopping_box_accountid'];
        }
        $result['verifyCode'] = md5($result['storeId'] . $result['roomId'] .
            $result['name'] . $result['date'] . $config['shopping_box_salt']);
        return $result;

    }

}
