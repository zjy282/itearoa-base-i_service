<?php

class Rpc_UrlConfig {

    private static $config = array(
        'U001' => array(
            'name' => '后台登录',
            'method' => 'getUserInfo',
            'auth' => true,
            'url' => 'http://service.youpu.cn/Adminuser/login',
            'param' => array(
                'username' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'password' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                )
            )
        )
    );

    /**
     * 根据接口编号获取接口配置
     *
     * @param string $interfaceId            
     * @param string $configKey            
     * @return multitype:multitype:string multitype:multitype:boolean string
     *         |boolean
     */
    public static function getConfig($interfaceId, $configKey = '') {
        if (isset(self::$config[$interfaceId])) {
            if (strlen($configKey) && isset(self::$config[$interfaceId][$configKey])) {
                return self::$config[$interfaceId][$configKey];
            } else {
                return self::$config[$interfaceId];
            }
        } else {
            return false;
        }
    }
}
