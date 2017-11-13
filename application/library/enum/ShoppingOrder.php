<?php

class Enum_ShoppingOrder
{

    const ORDER_STATUS_WAIT = 1;

    const ORDER_STATUS_SERVICE = 2;

    const ORDER_STATUS_COMPLETE = 3;

    const ROBOT_WAITING = 1;
    const ROBOT_GOING = 2;
    const ROBOT_ARRIVED = 3;
    const ROBOT_FINISHED = 4;
    const ROBOT_GUEST_NOT_FETCH = 5;
    const ROBOT_CANCELLED = 6;
    const ROBOT_BEGIN = 7;


    const ORDERS_ROOM_DIFFERENT = 1;

    const EXCEPTION_DIFFERENT_ROOM = "订单属于不同房间";


    const PUSH_MSG_CONTENT = "机器人购物信息";


    private static $orderPushStaffIdList = array(
        1 => array(5195, 140, 129, 739, 699)
    );

    public static function getOrderPushStaffIdList($hotelId)
    {
        return self::$orderPushStaffIdList[$hotelId];
    }

    private static $statsNameList = array(
        self::ORDER_STATUS_WAIT => '待处理',
        self::ORDER_STATUS_SERVICE => '处理中',
        self::ORDER_STATUS_COMPLETE => '已完成'
    );

    private static $robotStatusNameListForStaff = array(
        self::ROBOT_WAITING => '待处理',
        self::ROBOT_GOING => '机器人已出发',
        self::ROBOT_ARRIVED => '到达客户房间',
        self::ROBOT_FINISHED => '已送达',
        self::ROBOT_GUEST_NOT_FETCH => '客户未取物品',
        self::ROBOT_CANCELLED => '取消送货',
        self::ROBOT_BEGIN => '任务派发',

    );

    private static $robotStatusNameListForGuest = array(
        self::ROBOT_WAITING => '订单已提交，请稍等',
        self::ROBOT_GOING => '送货机器人已出发，请稍等',
        self::ROBOT_ARRIVED => '机器人已到达您的房间门口，请取货',
        self::ROBOT_FINISHED => '已送达',
        self::ROBOT_GUEST_NOT_FETCH => '您没有及时从机器人取货，机器人已返回',
        self::ROBOT_CANCELLED => '取消送货',
        self::ROBOT_BEGIN => '任务派发',

    );

    public static function getStatusNameList()
    {
        return self::$statsNameList;
    }

    /**
     * Get status name for staff
     *
     * @return array
     */
    public static function getRobotStatusNameList()
    {
        return self::$robotStatusNameListForStaff;
    }

    /**
     * Get status name for guest
     *
     * @return array
     */
    public static function getRobotStatusNameListForGuest()
    {
        return self::$robotStatusNameListForGuest;
    }


}

?>