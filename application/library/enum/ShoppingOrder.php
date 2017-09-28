<?php

class Enum_ShoppingOrder {

    const ORDER_STATUS_WAIT = 1;

    const ORDER_STATUS_SERVICE = 2;

    const ORDER_STATUS_COMPLATE = 3;

    private static $orderPushStaffIdList = array(
        1 => array(5195, 140, 129, 739, 699)
    );

    public static function getOrderPushStaffIdList($hotelId) {
        return self::$orderPushStaffIdList[$hotelId];
    }

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