<?php

class Enum_Push {

    const PUSH_TYPE_USER = 1;
    const PUSH_TYPE_STAFF = 2;
    const PUSH_TYPE_ALL = 3;
    const PUSH_TYPE_HOTEL = 4;
    const PUSH_TYPE_GROUP = 5;
    const PUSH_TYPE_ALIAS = 10;
    const PUSH_TYPE_TAG = 20;

    const PHONE_TYPE_ANDROID = 2;
    const PHONE_TYPE_IOS = 1;

    const PUSH_TAG_LANG_EN = 'en'; //英文语言
    const PUSH_TAG_LANG_CN = 'cn'; //中文语言
    const PUSH_TAG_HOTEL_PREFIX = 'hotel_';//酒店标签前缀
    const PUSH_TAG_GROUP_PREFIX = 'group_';//物业标签前缀
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
     * @reutrn array
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
