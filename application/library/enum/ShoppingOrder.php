<?php

class Enum_ShoppingOrder
{

    const ORDER_STATUS_WAIT = 1;

    const ORDER_STATUS_SERVICE = 2;

    const ORDER_STATUS_COMPLETE = 3;

    const ORDER_STATUS_CANCEL = 4;

    const ROBOT_WAITING = 1;
    const ROBOT_GOING = 2;
    const ROBOT_ARRIVED = 3;
    const ROBOT_FINISHED = 4;
    const ROBOT_GUEST_NOT_FETCH = 5;
    const ROBOT_CANCELLED = 6;
    const ROBOT_BEGIN = 7;


    const ORDERS_ROOM_DIFFERENT = 1;
    const ORDERS_POSITION_NOT_EXIST = 2;

    const ORDER_NOT_DELETE = 0;
    const ORDER_MARK_DELETE = 1;

    const EXCEPTION_DIFFERENT_ROOM = "订单属于不同房间";
    const EXCEPTION_HAVE_NO_DEST = "目标点位不存在";
    const EXCEPTION_ERROR_OUTPUT = 999;


    const PUSH_MSG_CONTENT = "机器人购物信息";
    const USER_ROBOT = '机器人';

    const LANGUAGE_LIST = array(
        Enum_Lang::CHINESE,
        Enum_Lang::ENGLISH
    );

    private static $statsNameList = array(
        Enum_Lang::CHINESE => array(
            self::ORDER_STATUS_WAIT => '待处理',
            self::ORDER_STATUS_SERVICE => '处理中',
            self::ORDER_STATUS_COMPLETE => '已完成',
            self::ORDER_STATUS_CANCEL => '已取消',
        ),
        Enum_Lang::ENGLISH => array(
            self::ORDER_STATUS_WAIT => 'Wait to process',
            self::ORDER_STATUS_SERVICE => 'Processing',
            self::ORDER_STATUS_COMPLETE => 'Finished',
            self::ORDER_STATUS_CANCEL => 'Cancelled'
        )
    );

    private static $robotStatusNameListForStaff = array(
        Enum_Lang::CHINESE => array(
            self::ROBOT_WAITING => '待处理',
            self::ROBOT_GOING => '机器人已出发',
            self::ROBOT_ARRIVED => '到达客户房间',
            self::ROBOT_FINISHED => '已送达',
            self::ROBOT_GUEST_NOT_FETCH => '客户未取物品',
            self::ROBOT_CANCELLED => '取消送货',
            self::ROBOT_BEGIN => '任务派发',
        ),

        Enum_Lang::ENGLISH => array(
            self::ROBOT_WAITING => 'Wait to process',
            self::ROBOT_GOING => 'Robot started off on delivering',
            self::ROBOT_ARRIVED => 'Robot arrived guest\'s room',
            self::ROBOT_FINISHED => 'Delivered',
            self::ROBOT_GUEST_NOT_FETCH => 'Guest didn\'t fetch the product',
            self::ROBOT_CANCELLED => 'Cancel delivering',
            self::ROBOT_BEGIN => 'Send task to robot',
        ),

    );

    private static $robotStatusTitle = array(
        Enum_Lang::CHINESE => '机器人送物',
        Enum_Lang::ENGLISH => 'Robot Delivery',
    );

    private static $robotStatusNameListForGuest = array(
        Enum_Lang::CHINESE => array(
            self::ROBOT_WAITING => '订单已提交，请稍等',
            self::ROBOT_GOING => '机器人正在派送你选订的物品，请在房间内等待收取物品',
            self::ROBOT_ARRIVED => '机器人已到达房间门口，请出门取物',
            self::ROBOT_FINISHED => '你选订的物品已完成送达',
            self::ROBOT_GUEST_NOT_FETCH => '您没有及时从机器人取货，机器人已返回',
            self::ROBOT_CANCELLED => '取消送货',
            self::ROBOT_BEGIN => '任务派发'),

        Enum_Lang::ENGLISH => array(
            self::ROBOT_WAITING => 'Your order is submit, please wait',
            self::ROBOT_GOING => 'The robot is delivering the items you ordered, please wait in the room',
            self::ROBOT_ARRIVED => 'The robot arrived at the door, please pick up the items',
            self::ROBOT_FINISHED => 'The items you ordered have been delivered',
            self::ROBOT_GUEST_NOT_FETCH => 'You didn\'t take the product in time, the robot returned to warehouse',
            self::ROBOT_CANCELLED => 'Your order is cancelled',
            self::ROBOT_BEGIN => 'Processing'),

    );

    public static function getStatusNameList($lang = 'zh')
    {
        if (!in_array($lang, self::LANGUAGE_LIST)) {
            $lang = Enum_Lang::CHINESE;
        }
        return self::$statsNameList[$lang];
    }

    public static function getStatusName($status, $lang = 'zh')
    {
        if (!in_array($lang, self::LANGUAGE_LIST)) {
            $lang = Enum_Lang::CHINESE;
        }
        $array = self::$statsNameList[$lang];
        return $array[$status];
    }

    /**
     * Get status name for staff
     *
     * @param string $language
     * @return array
     */
    public static function getRobotStatusNameList($language = 'zh'): array
    {
        if(!in_array($language, self::LANGUAGE_LIST)){
            $language = Enum_Lang::CHINESE;
        }
        return self::$robotStatusNameListForStaff[$language];
    }

    /**
     * Get status name for guest
     *
     * @param string $language
     * @return array
     */
    public static function getRobotStatusNameListForGuest($language = 'zh'): array
    {
        if(!in_array($language, self::LANGUAGE_LIST)){
            $language = Enum_Lang::CHINESE;
        }
        return self::$robotStatusNameListForGuest[$language];
    }

    /**
     * @param string $language
     * @return string
     */
    public static function getRobotStatusTitle($language = 'zh'):string {
        if(!in_array($language, self::LANGUAGE_LIST)){
            $language = Enum_Lang::CHINESE;
        }
        return self::$robotStatusTitle[$language];
    }


}

?>