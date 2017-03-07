<?php

/**
 * 设备类型枚举
 * @author ZXM
 */
class Enum_Platform {

    /**
     * iphone设备标识 int
     */
    const PLATFORM_ID_IPHONE = 1;

    /**
     * 安卓设备标识 int
     */
    const PLATFORM_ID_ANDROID = 2;

    /**
     * 设备标识名称字典 array
     */
    private static $platformNameList = array(
        self::PLATFORM_ID_IPHONE => 'Iphone',
        self::PLATFORM_ID_ANDROID => '安卓'
    );

    /**
     * 获取设备标识名称字典
     *
     * @return array
     */
    public static function getPlatformNameList() {
        return self::$platformNameList;
    }
}
?>