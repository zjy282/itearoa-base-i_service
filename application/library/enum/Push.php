<?php

class Enum_Push {

    /**
     * 推送机型定义
     */
    private static $phoneTypes = array(
        'android',
        'ios'
    );

    /**
     * 按平台 系统获取对应的配置
     *
     * @reutrn array
     */
    public static function getPhoneTypes() {
        return self::$phoneTypes;
    }

    /**
     * 推送平台对应的密钥
     */
    private static $config = array(
        'umeng' => array(
            'android' => array(
                'appKey' => '58cc983a310c937554002429',
                'secretKey' => '16jks3ps5b5go2ox4lcym8q9mq2f9l4a'
            ),
            'ios' => array(
                'appKey' => '58cc983a310c937554002429',
                'secretKey' => '16jks3ps5b5go2ox4lcym8q9mq2f9l4a'
            )
        )
    );

    /**
     * 按平台 系统获取对应的配置
     *
     * @param $platform string            
     * @param $system string
     *            @reutrn array
     */
    public static function getConfig($platform, $system = '') {
        $platform = strtolower($platform);
        if ($system) {
            $system = strtolower($system);
            return self::$config[$platform][$system];
        } else {
            return self::$config[$platform];
        }
    }
}
