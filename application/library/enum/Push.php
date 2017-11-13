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
    const PUSH_ALIAS_USER_PREFIX = 'user';//用户别名前缀
    const PUSH_ALIAS_STAFF_PREFIX = 'staff';//员工别名前缀

    const PUSH_CONTENT_TYPE_URL = 'url';
    const PUSH_CONTENT_TYPE_SHOPPING_ORDER = 'shopping_order';

    const PLATFORM = 'umeng';

    private static $_config;

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
     * Get push msg key
     *
     * @param string $platform
     * @param string $system
     * @return mixed
     */
    public static function getConfig($platform = self::PLATFORM, $system = '')
    {
        if (empty(self::$_config)) {
            self::$_config = Yaf_Registry::get('sysConfig');
        }
        $msgConfig = self::$_config[$platform];
        if (!empty($system)) {
            return $msgConfig[$system];
        } else {
            return $msgConfig;
        }
    }
}
