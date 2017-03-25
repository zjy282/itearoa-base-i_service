<?php

/**
 * 验证登录
 * @author ZXM
 * 2015年9月22日
 */
class Auth_Login {

    private static $memKeyPrefix = "login";

    /**
     * 验证是否已经登录
     *
     * @return array|boolean
     */
    public static function checkLogin() {
        $loginInfo = Yaf_Registry::get('loginInfo');
        if (is_array($loginInfo) && count($loginInfo) > 0 && $loginInfo['id']) {
            return $loginInfo;
        }
        return false;
    }

    /**
     * 生成sid和aid
     *
     * @param array $userInfo            
     * @return array
     */
    public static function genSIdAndAId($userId) {
        $sId = md5(Enum_Login::LOGIN_USER_SAVE_KEY . "_{$userId}_" . time());
        $sId = substr($sId, 0, 8) . "-" . substr($sId, 8, 8) . "-" . substr($sId, 16, 8) . "-" . substr($sId, 24, 8);
        $aId = md5(self::$memKeyPrefix . "_{$userId}_" . time());
        return array(
            'sId' => $sId,
            'aId' => $aId
        );
    }

    /**
     * 生成登录memcache key
     *
     * @param string $sId            
     * @param string $aId            
     * @return string
     */
    public static function genLoginMemKey($sId, $aId) {
        return $sId . '_' . $aId . '_' . self::$memKeyPrefix;
    }

    /**
     * 生成sign
     *
     * @param array $paramList            
     * @return string
     */
    public static function genSign($paramList) {
        $sysConfig = Yaf_Registry::get('sysConfig');
        ksort($paramList);
        $paramStr = '';
        foreach ($paramList as $key => $value) {
            $paramStr .= $key . $value;
        }
        $sign = md5($paramStr . $sysConfig->api->sign);
        return $sign;
    }

    /**
     * 生成Token
     *
     * @param int $memberId            
     * @return boolean|string
     */
    public static function makeToken($memberId) {
        $resultToken = false;
        if ($memberId) {
            $sysConfig = Yaf_Registry::get('sysConfig');
            $loginToken = self::makeLoginToken($memberId);
            $resultToken = md5($loginToken . time());
            $loginInfo = json_encode(array(
                'memberId' => $memberId,
                'token' => $resultToken
            ));
            
            $redis = Cache_Redis::getInstance();
            $redis->set($loginToken, $loginInfo, $sysConfig->auth->timeout);
            $redis->set($resultToken, $loginToken, $sysConfig->auth->timeout);
        }
        return $resultToken;
    }

    /**
     * 生成logintoken
     *
     * @param unknown $memberId            
     * @return string
     */
    private static function makeLoginToken($memberId, $package = '') {
        $sysConfig = Yaf_Registry::get('sysConfig');
        $loginToken = md5("{$sysConfig->auth->prefix}_{$memberId}");
        return $loginToken;
    }

    /**
     * 根据token获取memberid
     *
     * @param string $resultToken            
     * @return Ambigous <对应key的数据, mixed>
     */
    public static function getToken($resultToken) {
        $memberId = 0;
        if (! empty($resultToken)) {
            $redis = Cache_Redis::getInstance();
            $loginToken = $redis->get($resultToken);
            if ($loginToken) {
                $loginInfo = $redis->get($loginToken);
                if ($loginInfo) {
                    $loginInfo = json_decode($loginInfo, true);
                    if ($loginInfo['token'] == $resultToken) {
                        $memberId = $loginInfo['memberId'];
                    }
                }
            }
        }
        
        return $memberId;
    }
}

?>