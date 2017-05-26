<?php

/**
 * 评论枚举
 * @author ZXM
 */
class Enum_Comment {

    const COMMENT_STATUS_ONLINE = 1;
    const COMMENT_STATUS_WAITREVIEW = 2;

    const COMMENT_TYPE_HOTEL_FLOOR = 1;
    const COMMENT_TYPE_HOTEL_FACILITIES = 2;
    const COMMENT_TYPE_HOTEL_TRAFFIC = 3;
    const COMMENT_TYPE_HOTEL_LIFE = 4;
    const COMMENT_TYPE_HOTEL_POI = 5;
    const COMMENT_TYPE_HOTEL_PROMOTION = 6;
    const COMMENT_TYPE_HOTEL_ROOMTYPE = 7;
    const COMMENT_TYPE_HOTEL_ROOMRES = 8;
    const COMMENT_TYPE_HOTEL_SHOPPING = 9;
    const COMMENT_TYPE_HOTEL_ACTIVITY = 10;
    const COMMENT_TYPE_HOTEL_NEWS = 11;
    const COMMENT_TYPE_HOTEL_NOTICE = 12;
    const COMMENT_TYPE_GROUP_ACTIVITY = 13;
    const COMMENT_TYPE_GROUP_NEWS = 14;
    const COMMENT_TYPE_GROUP_NOTICE = 15;

    public static function getCommentTypeList() {
        $typeList = array(
            self::COMMENT_TYPE_HOTEL_FLOOR => 'hotelFloor',
            self::COMMENT_TYPE_HOTEL_FACILITIES => 'hotelFacilities',
            self::COMMENT_TYPE_HOTEL_TRAFFIC => 'hotelTraffic',
            self::COMMENT_TYPE_HOTEL_LIFE => 'hotelLife',
            self::COMMENT_TYPE_HOTEL_POI => 'hotelPoi',
            self::COMMENT_TYPE_HOTEL_PROMOTION => 'hotelPromotion',
            self::COMMENT_TYPE_HOTEL_ROOMTYPE => 'hotelRoomType',
            self::COMMENT_TYPE_HOTEL_ROOMRES => 'hotelRoomRes',
            self::COMMENT_TYPE_HOTEL_SHOPPING => 'hotelShopping',
            self::COMMENT_TYPE_HOTEL_ACTIVITY => 'hotelActivity',
            self::COMMENT_TYPE_HOTEL_NEWS => 'hotelNews',
            self::COMMENT_TYPE_HOTEL_NOTICE => 'hotelNotice',
            self::COMMENT_TYPE_GROUP_ACTIVITY => 'groupActivity',
            self::COMMENT_TYPE_GROUP_NEWS => 'groupNews',
            self::COMMENT_TYPE_GROUP_NOTICE => 'groupNotice',
        );
        return $typeList;
    }

    public static function getHotelCommentTypeList() {
        $typeList = array(
            self::COMMENT_TYPE_HOTEL_FLOOR => 'hotelFloor',
            self::COMMENT_TYPE_HOTEL_FACILITIES => 'hotelFacilities',
            self::COMMENT_TYPE_HOTEL_TRAFFIC => 'hotelTraffic',
            self::COMMENT_TYPE_HOTEL_LIFE => 'hotelLife',
            self::COMMENT_TYPE_HOTEL_POI => 'hotelPoi',
            self::COMMENT_TYPE_HOTEL_PROMOTION => 'hotelPromotion',
            self::COMMENT_TYPE_HOTEL_ROOMTYPE => 'hotelRoomType',
            self::COMMENT_TYPE_HOTEL_ROOMRES => 'hotelRoomRes',
            self::COMMENT_TYPE_HOTEL_SHOPPING => 'hotelShopping',
            self::COMMENT_TYPE_HOTEL_ACTIVITY => 'hotelActivity',
            self::COMMENT_TYPE_HOTEL_NEWS => 'hotelNews',
            self::COMMENT_TYPE_HOTEL_NOTICE => 'hotelNotice',
        );
        return $typeList;
    }

    public static function getGroupCommentTypeList() {
        $typeList = array(
            self::COMMENT_TYPE_GROUP_ACTIVITY => 'groupActivity',
            self::COMMENT_TYPE_GROUP_NEWS => 'groupNews',
            self::COMMENT_TYPE_GROUP_NOTICE => 'groupNotice',
        );
        return $typeList;
    }
}

?>