<?php

/**
 * GSM接口枚举
 * @author ZXM
 */
class Enum_Gsm {

    const GSM_INTERFACE = 'https://iservices-gsm.the-ascott.com.cn';
    const STAFF_INTERFACE = 'https://iservices-staff.the-ascott.com.cn';

    const SECERTKEY = 'iServicesExtra';

    const USER_LOGIN_PATH = '/Trans/AuthTrans2';
    const USER_REDIRECT_PATH = '/Trans/AuthRedirect2';

    const STAFF_LOGIN_METHOD = self::STAFF_INTERFACE . '/Trans/Auth';

    const USER_REDIRECT_METHOD = self::GSM_INTERFACE . '/Trans/AuthRedirect2';
    const STAFF_REDIRECT_METHOD = self::STAFF_INTERFACE . '/Trans/Redirect';

    public static function genEncryptGsmParams($paramList)
    {
        $paramListStr = implode('', array_values($paramList));
        $verifyStr = md5($paramListStr . self::SECERTKEY);
        $paramList['VerifyStr'] = strtoupper($verifyStr);
        return $paramList;
    }

    /**
     * Return the login url from group port_url
     *
     * @param $groupId
     * @return string
     */
    public static function getUserLoginUrl($groupId): string
    {
        $model = new GroupModel();
        $groupInfo = $model->getGroupDetail(intval($groupId));
        $host = self::GSM_INTERFACE;
        if (isset($groupInfo['port_url']) && !empty($groupInfo['port_url'])) {
            $host = $groupInfo['port_url'];
        }
        return $host . self::USER_LOGIN_PATH;
    }

    /**
     * Return redirect url path from group port_url
     *
     * @param $groupId
     * @return string
     */
    public static function getUserRedirectUrl($groupId): string
    {
        $model = new GroupModel();
        $groupInfo = $model->getGroupDetail(intval($groupId));
        $host = self::GSM_INTERFACE;
        if (isset($groupInfo['port_url']) && !empty($groupInfo['port_url'])) {
            $host = $groupInfo['port_url'];
        }
        return $host . self::USER_REDIRECT_PATH;

    }

}

?>