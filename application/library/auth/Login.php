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
        $sign = md5($sysConfig->api->sign . md5(implode("", $paramList) . $sysConfig->api->sign));
        return $sign;
    }
}

?>