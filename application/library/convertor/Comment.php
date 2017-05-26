<?php

/**
 * 酒店评论转换器类
 *
 */
class Convertor_Comment extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 后台酒店评论列表
     *
     * @param array $list
     *            酒店评论列表
     * @param int $count
     *            酒店评论列表总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getCommentListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $dataIdList = array_column($list, 'dataid', 'id');
        $dataIdList = array_filter(array_unique($dataIdList));
        switch ($param['datatype']) {
            case Enum_Comment::COMMENT_TYPE_HOTEL_FLOOR:
                $floorModel = new FloorModel();
                $dataInfoList = $floorModel->getFloorList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'floor', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_FACILITIES:
                $facilitiesModel = new FacilitiesModel();
                $dataInfoList = $facilitiesModel->getFacilitiesList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'name_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_TRAFFIC:
                $trafficModel = new TrafficModel();
                $dataInfoList = $trafficModel->getTrafficList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'introduct_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_LIFE:
                $lifeModel = new LifeModel();
                $dataInfoList = $lifeModel->getLifeList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'name_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_POI:
                $poiModel = new PoiModel();
                $dataInfoList = $poiModel->getPoiList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'name_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_PROMOTION:
                $promotionModel = new PromotionModel();
                $dataInfoList = $promotionModel->getPromotionList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_ROOMTYPE:
                $roomtypeModel = new RoomtypeModel();
                $dataInfoList = $roomtypeModel->getRoomtypeList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_ROOMRES:
                $roomResModel = new RoomResModel();
                $dataInfoList = $roomResModel->getRoomResList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'name_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_SHOPPING:
                $shoppingModel = new ShoppingModel();
                $dataInfoList = $shoppingModel->getShoppingList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_ACTIVITY:
                $activityModel = new ActivityModel();
                $dataInfoList = $activityModel->getActivityList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_NEWS:
                $newsModel = new NewsModel();
                $dataInfoList = $newsModel->getNewsList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_HOTEL_NOTICE:
                $noticModel = new NoticModel();
                $dataInfoList = $noticModel->getNoticList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_GROUP_ACTIVITY:
                $groupActivityModel = new GroupActivityModel();
                $dataInfoList = $groupActivityModel->getActivityList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_GROUP_NEWS:
                $groupNewsModel = new GroupNewsModel();
                $dataInfoList = $groupNewsModel->getNewsList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
            case Enum_Comment::COMMENT_TYPE_GROUP_NOTICE:
                $groupNoticeModel = new GroupNoticeModel();
                $dataInfoList = $groupNoticeModel->getNoticList(array('id' => $dataIdList));
                $dataNameList = array_column($dataInfoList, 'title_lang1', 'id');
                break;
        }
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['userid'] = $value ['userid'];
            $oneTemp ['roomno'] = $value ['roomno'];
            $oneTemp ['fullname'] = $value ['fullname'];
            $oneTemp ['value'] = $value ['value'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['status'] = $value ['status'];
            $oneTemp ['ip'] = $value ['ip'];
            $oneTemp ['datatype'] = $value ['datatype'];
            $oneTemp ['dataid'] = $value ['dataid'];
            $oneTemp ['datatitle'] = $dataNameList[$value ['dataid']];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['groupid'] = $value ['groupid'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 评论列表
     *
     * @param array $list
     *            酒店评论列表
     * @return array
     */
    public function commentListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['userid'] = $value ['userid'];
            $oneTemp ['roomno'] = $value ['roomno'];
            $oneTemp ['fullname'] = $value ['fullname'];
            $oneTemp ['value'] = $value ['value'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['ip'] = $value['ip'] ? Util_Tools::ntoip($value['ip']) : '';
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['groupid'] = $value ['groupid'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
