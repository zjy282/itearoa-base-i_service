<?php

/**
 * 验证登录
 * @author ZXM
 * 2015年9月22日
 */
class Auth_Login {

    const USER_MARK = 1;
    const STAFF_MARK = 2;

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
     * Generate token and store it in redis
     *
     * @param $memberId
     * @param int $type
     * @param int $timeout
     * @return bool|string
     */
    public static function makeToken($memberId, $type = self::USER_MARK, int $timeout = 0) {
        $resultToken = false;
        if ($memberId) {
            $sysConfig = Yaf_Registry::get('sysConfig');
            $loginToken = self::makeLoginToken($memberId, $type);
            $resultToken = md5($loginToken . time());
            $loginInfo = json_encode(array(
                'memberId' => $memberId,
                'token' => $resultToken,
                'type' => $type
            ));

            if ($timeout <= 0) {
                $timeout = $sysConfig->auth->timeout;
            }
            
            $redis = Cache_Redis::getInstance();
            $redis->set($loginToken, $loginInfo, $timeout);
            $redis->set($resultToken, $loginToken, $timeout);
        }
        return $resultToken;
    }

    /**
     * 生成logintoken
     *
     * @param mixed $memberId
     * @return string
     */
    private static function makeLoginToken($memberId, $type = 1) {
        $sysConfig = Yaf_Registry::get('sysConfig');
        $loginToken = md5("{$sysConfig->auth->prefix}_{$memberId}_" . $type);
        return $loginToken;
    }

    /**
     * 根据token获取memberid
     *
     * @param $resultToken
     * @param int $type
     * @param bool $isMulti allow multiple point login
     * @return int
     */
    public static function getToken($resultToken, $type = self::USER_MARK, $isMulti = true)
    {
        $memberId = 0;
        if (!empty($resultToken)) {
            $redis = Cache_Redis::getInstance();
            $loginToken = $redis->get($resultToken);
            if ($loginToken) {
                $loginInfo = $redis->get($loginToken);
                if ($loginInfo) {
                    $loginInfo = json_decode($loginInfo, true);
                    if (($loginInfo['token'] == $resultToken || $isMulti) && $loginInfo['type'] == $type) {
                        $memberId = $loginInfo['memberId'];
                    }
                }
            }
        }

        return $memberId;
    }


    public static function getRobotSign($params){

        $sysConfig = Yaf_Registry::get('sysConfig');

        $ts = $params['ts'];
        $appName = $sysConfig->robot->appName;
        $secretKey = $sysConfig->robot->secretKey;

        unset($params['ts'], $params['appname']);
        ksort($params);
        $string = '';
        foreach ($params as $key => $value) {
            $string .= $key . ":" . $value . "|";
        }
        $string .= "appname:" . $appName . "|";
        $string .= "secret:" . $secretKey . "|";
        $string .= "ts:" . $ts;
        $sign = md5($string);
        return $sign;
    }
}

?>