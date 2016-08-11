<?php

class Interceptor_LoginConfig {

    const LOGIN_INTERCEPTOR = 'Interceptor_LoginAuth';

    private static $allowConfig = array(
        'Login,index',
        'Login,logout',
        'Loginajax,dologin',
        'Error,denyaccess'
    );

    /**
     * 获取拦截器配置
     *
     * @return array
     */
    public static function getAllowConfig() {
        return self::$allowConfig;
    }
}

?>