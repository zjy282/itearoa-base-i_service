<?php

/**
 * 物业管理员枚举
 * @author ZXM
 */
class Enum_HotelAdministrator {

    private static $permission = array(
        1 => '物业管理',
        2 => '活动管理',
        3 => '雅士阁生活',
        4 => '本地攻略',
        5 => '物业促销',
        6 => '客房管理',
        7 => '体验购物',
        8 => '预约看房',
        9 => '电话黄页',
        10 => '物业新闻',
        11 => '物业通知',
        12 => '调查反馈',
        13 => 'APP管理',
        14 => '评论管理',
        15 => '互动服务',
    );

    public static function getPermission() {
        return self::$permission;
    }
}

?>
