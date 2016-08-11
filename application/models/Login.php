<?php

class LoginModel extends \BaseModel {

    /**
     * 获取登陆用户信息
     * ---
     *
     * @param $username 用户名            
     * @param $password 密码            
     * @return array
     */
    public function getUserInfo($paramList) {
        $params = $this->initParam($paramList);
        
        do {
            $params['username'] = trim($paramList['username']);
            $params['password'] = trim($paramList['password']);
            
            if (! $params['username'] || ! $params['password']) {
                $result = array(
                    'code' => 1,
                    'msg' => '用户名或密码不能为空！'
                );
                break;
            }
            $params['password'] = Enum_Login::getMd5Pass($params['password']);
            $result = $this->rpcClient->getResultRaw('U001', $params);
        } while (false);
        return $result;
    }

    /**
     * 执行登录
     *
     * @param array $paramList            
     * @return Ambigous <multitype:number string , multitype:>
     */
    public function doLogin($paramList) {
        do {
            $result = $this->getUserInfo($paramList);
            if ($result['code']) {
                break;
            }
            $userInfo = $result['data'];
            $errorResult = array(
                'code' => 1,
                'msg' => '登录失败'
            );
            if (empty($userInfo['id'])) {
                $result = $errorResult;
                break;
            }
            if (empty($userInfo['partnerId'])) {
                $result = $errorResult;
                break;
            }
            $auth = Auth_Login::genSIdAndAId($userInfo['id']);
            $partnerList = $this->rpcClient->getResultRaw('P001', array())['data']['list'];
            $partnerList = array_column($partnerList, 'name', 'id');
            $userInfo['sId'] = $auth['sId'];
            $userInfo['partnerName'] = $partnerList[$userInfo['partnerId']];
            $key = Auth_Login::genLoginMemKey($auth['sId'], $auth['aId']);
            $cache = Cache_MemoryCache::getInstance();
            if (! $cache->set($key, json_encode($userInfo), Enum_Login::LOGIN_TIMEOUT)) {
                $result = $errorResult;
                break;
            }
            $cookieTime = time() + Enum_Login::LOGIN_TIMEOUT;
            if (! Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_AID, $auth['aId'], $cookieTime)) {
                $result = $errorResult;
                break;
            }
            if (! Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_SID, $auth['sId'], $cookieTime)) {
                $result = $errorResult;
                break;
            }
            $result['data']['insertId'] = $result['data']['id'];
            Enum_Record::setRecordData('adminId', $result['data']['id']);
        } while (false);
        return $result;
    }

    /**
     * 退出登录
     *
     * @return boolean
     */
    public function loginOut() {
        if ($loginInfo = Auth_Login::checkLogin()) {
            $sId = Util_Http::getCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_SID);
            $aId = Util_Http::getCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_AID);
            if ($sId && $aId) {
                $memKey = Auth_Login::genLoginMemKey($sId, $aId);
                Cache_MemoryCache::getInstance()->delete($memKey);
            }
            Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_SID, '', time());
            Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_AID, '', time());
            return true;
        }
    }

    /**
     * 根据用户获取权限列表
     *
     * @return Ambigous
     */
    public function getRuleList($paramList) {
        $params = $this->initParam($paramList);
        do {
            if (empty($params['id'])) {
                $result = array(
                    'code' => 1,
                    'msg' => '用户ID错误'
                );
                break;
            }
            $params['project'] = Enum_System::RULE_MENU_PROJECT_ID;
            $result = $this->rpcClient->getResultRaw('U002', $params, true, 10, false, 1800);
        } while (false);
        return $result;
    }
}
