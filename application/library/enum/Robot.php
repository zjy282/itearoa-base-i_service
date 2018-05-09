<?php

class Enum_Robot
{
    const ROBOT_WAITING = 1;
    const ROBOT_GOING = 2;
    const ROBOT_ARRIVED = 3;
    const ROBOT_FINISHED = 4;
    const ROBOT_GUEST_NOT_PUT = 5;
    const ROBOT_CANCELLED = 6;
    const ROBOT_BEGIN = 7;

    const LANGUAGE_LIST = array(
        Enum_Lang::CHINESE,
        Enum_Lang::ENGLISH
    );


    private static $robotStatusNameListForStaff = array(
        Enum_Lang::CHINESE => array(
            self::ROBOT_WAITING => '待处理',
            self::ROBOT_GOING => '机器人已出发',
            self::ROBOT_ARRIVED => '到达客户房间',
            self::ROBOT_FINISHED => '已送达',
            self::ROBOT_GUEST_NOT_PUT => '客户未放入物品',
            self::ROBOT_CANCELLED => '取消送货',
            self::ROBOT_BEGIN => '任务派发',
        ),

        Enum_Lang::ENGLISH => array(
            self::ROBOT_WAITING => 'Wait to process',
            self::ROBOT_GOING => 'Robot started off on delivering',
            self::ROBOT_ARRIVED => 'Robot arrived guest\'s room',
            self::ROBOT_FINISHED => 'Delivered',
            self::ROBOT_GUEST_NOT_PUT => 'Guest didn\'t put the product into the robot',
            self::ROBOT_CANCELLED => 'Cancel delivering',
            self::ROBOT_BEGIN => 'Send task to robot',
        ),

    );

    private static $robotStatusNameListForGuest = array(
        Enum_Lang::CHINESE => array(
            self::ROBOT_WAITING => '订单已提交，请稍等',
            self::ROBOT_GOING => '机器人已出发，请在房间内等待',
            self::ROBOT_ARRIVED => '机器人已到达房间门口，请将物品放入机器人内',
            self::ROBOT_FINISHED => '机器人已完成送达',
            self::ROBOT_GUEST_NOT_PUT => '您没有及时将物品放入机器人，机器人已返回',
            self::ROBOT_CANCELLED => '取消送货',
            self::ROBOT_BEGIN => '任务派发'),

        Enum_Lang::ENGLISH => array(
            self::ROBOT_WAITING => 'Your order is submit, please wait',
            self::ROBOT_GOING => 'Robot started off, please wait in the room',
            self::ROBOT_ARRIVED => 'The robot arrived at the door, please put the items into the robot',
            self::ROBOT_FINISHED => 'Your items have been delivered',
            self::ROBOT_GUEST_NOT_PUT => 'You didn\'t put the product in time, the robot returned',
            self::ROBOT_CANCELLED => 'Your order is cancelled',
            self::ROBOT_BEGIN => 'Order started'),

    );

    /**
     * the number indicate the exception message can be output
     */
    const EXCEPTION_OUTPUT_NUM = 999;
    const EXCEPTION_CANNOT_FIND_YOUR_ROOM = 'Can not find your room';
    const EXCEPTION_ROOM_NOT_TAGGED = 'Your room not tagged by admin';
    const EXCEPTION_POSITION_NOT_FOUND = 'Position not found';

    /**
     * Get status name for staff
     *
     * @param string $language
     * @return array
     */
    public static function getRobotStatusNameList($language = 'zh'): array
    {
        if (!in_array($language, self::LANGUAGE_LIST)) {
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
        if (!in_array($language, self::LANGUAGE_LIST)) {
            $language = Enum_Lang::CHINESE;
        }
        return self::$robotStatusNameListForGuest[$language];
    }


}