<?php

/**
 * GSM接口枚举
 * @author ZXM
 */
class Enum_Gsm {

    const GSM_INTERFACE = 'https://driservices-gsm.the-ascott.com.cn';
    const STAFF_INTERFACE = 'https://driservices-staff.the-ascott.com.cn';

    const SECERTKEY = 'iServicesExtra';

    const USER_LOGIN_METHOD = self::GSM_INTERFACE . '/Trans/AuthTrans2';
    const STAFF_LOGIN_METHOD = self::STAFF_INTERFACE . '/Trans/Auth';

    const USER_REDIRECT_METHOD = self::GSM_INTERFACE . '/Trans/AuthRedirect2';
    const STAFF_REDIRECT_METHOD = self::STAFF_INTERFACE . '/Trans/Redirect';

    public static function genEncryptGsmParams($paramList) {
        $paramListStr = implode('', array_values($paramList));
        $verifyStr = md5($paramListStr . self::SECERTKEY);
        $paramList['VerifyStr'] = strtoupper($verifyStr);
        return $paramList;
    }
}

?>