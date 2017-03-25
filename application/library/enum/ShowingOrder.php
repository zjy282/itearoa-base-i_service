<?php

class Enum_ShowingOrder {

    const ORDER_STATUS_WAIT = 1;

    const ORDER_STATUS_SERVICE = 2;

    const ORDER_STATUS_COMPLATE = 3;

    private static $statsNameList = array(
        self::ORDER_STATUS_WAIT => '待处理',
        self::ORDER_STATUS_SERVICE => '处理中',
        self::ORDER_STATUS_COMPLATE => '已完成'
    );

    public static function getStatusNameList() {
        return self::$statsNameList;
    }
}
?>