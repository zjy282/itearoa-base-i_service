<?php

/**
 * 评论控制器类
 *
 */
class CommentController extends \BaseController {

    /**
     *
     * @var CommentModel
     */
    private $model;

    /**
     *
     * @var Convertor_Comment
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new CommentModel();
        $this->convertor = new Convertor_Comment();
    }

    /**
     * 获取物业评论类型列表
     */
    public function getHotelCommentTypeListAction() {
        $this->echoSuccessData(array('list' => Enum_Comment::getHotelCommentTypeList()));
    }

    /**
     * 获取集团评论类型列表
     */
    public function getGroupCommentTypeListAction() {
        $this->echoSuccessData(array('list' => Enum_Comment::getGroupCommentTypeList()));
    }

    /**
     * 获取评论列表
     *
     * @return Json
     */
    public function getCommentListAction() {
        $param = array();
        $this->getPageParam($param);
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['datatype'] = intval($this->getParamList('datatype'));
        $param ['dataid'] = intval($this->getParamList('dataid'));
        $param ['roomno'] = trim($this->getParamList('roomno'));
        $param ['status'] = intval($this->getParamList('status'));
        if (empty($param['datatype'])) {
            $this->throwException(2, '评论类型不能为空');
        }
        $data = $this->model->getCommentList($param);
        $count = $this->model->getCommentCount($param);
        $data = $this->convertor->getCommentListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改评论信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateCommentByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updateCommentById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 新建评论
     * @param $paramList
     * @return array|exception
     */
    private function createComment($paramList) {
        $paramList['dataid'] = intval($this->getParamList('id'));
        $paramList['userid'] = intval($this->getParamList('userid'));
        $paramList['value'] = trim($this->getParamList('value'));
        $ip = trim($this->getParamList('ip'));
        $ip = $ip ? $ip : Util_Http::getIP();
        $ip && $paramList['ip'] = Util_Tools::ipton($ip);
        $paramList['hotelid'] = intval($this->getParamList('hotelid'));

        if (empty($paramList['dataid'])) {
            $this->throwException(2, '数据ID错误');
        }
        if (empty($paramList['userid'])) {
            $this->throwException(3, '用户ID错误');
        }
        if (empty($paramList['hotelid'])) {
            $this->throwException(4, '物业ID错误');
        }
        if (empty($paramList['value'])) {
            $this->throwException(7, '评论内容不能为空');
        }

        $userModel = new UserModel();
        $userInfo = $userModel->getUserDetail($paramList['userid']);
        if (empty($userInfo)) {
            $this->throwException(5, '用户信息获取错误');
        }
        $paramList['roomno'] = $userInfo['room_no'];
        $paramList['fullname'] = $userInfo['fullname'];

        $hotelModel = new HotelListModel();
        $hotelInfo = $hotelModel->getHotelListDetail($paramList['hotelid']);
        if (empty($hotelInfo)) {
            $this->throwException(6, '物业信息获取错误');
        }
        $paramList['groupid'] = $hotelInfo['groupid'];
        $paramList['status'] = Enum_Comment::COMMENT_STATUS_WAITREVIEW;
        $data = $this->model->addComment($paramList);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        return $data;
    }

    /**
     * 新建物业楼层评论
     */
    public function createFloorCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_FLOOR));
        $this->echoSuccessData($result);
    }

    /**
     * 新建物业设施评论
     */
    public function createFacilitiesCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_FACILITIES));
        $this->echoSuccessData($result);
    }

    /**
     * 新建物业交通评论
     */
    public function createTrafficCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_TRAFFIC));
        $this->echoSuccessData($result);
    }

    /**
     * 新建雅士阁生活评论
     */
    public function createLifeCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_LIFE));
        $this->echoSuccessData($result);
    }

    /**
     * 新建本地攻略评论
     */
    public function createPoiCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_POI));
        $this->echoSuccessData($result);
    }

    /**
     * 新建物业促销评论
     */
    public function createPromotionCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_PROMOTION));
        $this->echoSuccessData($result);
    }

    /**
     * 新建房型评论
     */
    public function createRoomTypeCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_ROOMTYPE));
        $this->echoSuccessData($result);
    }

    /**
     * 新建房间物品评论
     */
    public function createRoomResCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_ROOMRES));
        $this->echoSuccessData($result);
    }

    /**
     * 新建体验购物评论
     */
    public function createShoppingCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_SHOPPING));
        $this->echoSuccessData($result);
    }

    /**
     * 新建物业活动评论
     */
    public function createHotelActivityCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_ACTIVITY));
        $this->echoSuccessData($result);
    }

    /**
     * 新建物业新闻评论
     */
    public function createHotelNewsCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_NEWS));
        $this->echoSuccessData($result);
    }

    /**
     * 新建物业通知评论
     */
    public function createHotelNoticCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_NOTICE));
        $this->echoSuccessData($result);
    }

    /**
     * 新建集团活动评论
     */
    public function createGroupActivityCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_GROUP_ACTIVITY));
        $this->echoSuccessData($result);
    }

    /**
     * 新建集团新闻评论
     */
    public function createGroupNewsCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_GROUP_NEWS));
        $this->echoSuccessData($result);
    }

    /**
     * 新建集团通知评论
     */
    public function createGroupNoticCommentAction() {
        $result = $this->createComment(array('datatype' => Enum_Comment::COMMENT_TYPE_GROUP_NOTICE));
        $this->echoSuccessData($result);
    }

    /**
     * APP获取评论列表
     * @param $paramList
     * @return array|exception
     */
    private function getCommentList($paramList) {
        $paramList['dataid'] = intval($this->getParamList('id'));
        if (empty($paramList['dataid'])) {
            $this->throwException(2, '数据ID错误');
        }
        $this->getPageParam($paramList);
        $paramList ['status'] = Enum_Comment::COMMENT_STATUS_ONLINE;
        $data = $this->model->getCommentList($paramList);
        $count = $this->model->getCommentCount($paramList);
        $data = $this->convertor->commentListConvertor($data, $count, $paramList);
        return $data;
    }

    /**
     * 获取物业楼层评论列表
     */
    public function getFloorCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_FLOOR));
        $this->echoSuccessData($result);
    }

    /**
     * 获取物业设施评论列表
     */
    public function getFacilitiesCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_FACILITIES));
        $this->echoSuccessData($result);
    }

    /**
     * 获取物业交通评论列表
     */
    public function getTrafficCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_TRAFFIC));
        $this->echoSuccessData($result);
    }

    /**
     * 获取雅士阁生活评论列表
     */
    public function getLifeCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_LIFE));
        $this->echoSuccessData($result);
    }

    /**
     * 获取本地攻略评论列表
     */
    public function getPoiCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_POI));
        $this->echoSuccessData($result);
    }

    /**
     * 获取物业促销评论列表
     */
    public function getPromotionCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_PROMOTION));
        $this->echoSuccessData($result);
    }

    /**
     * 获取房型评论列表
     */
    public function getRoomTypeCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_ROOMTYPE));
        $this->echoSuccessData($result);
    }

    /**
     * 获取房间物品评论列表
     */
    public function getRoomResCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_ROOMRES));
        $this->echoSuccessData($result);
    }

    /**
     * 获取体验购物评论列表
     */
    public function getShoppingCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_SHOPPING));
        $this->echoSuccessData($result);
    }

    /**
     * 获取物业活动评论列表
     */
    public function getHotelActivityCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_ACTIVITY));
        $this->echoSuccessData($result);
    }

    /**
     * 获取物业新闻评论列表
     */
    public function getHotelNewsCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_NEWS));
        $this->echoSuccessData($result);
    }

    /**
     * 获取物业通知评论列表
     */
    public function getHotelNoticCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_HOTEL_NOTICE));
        $this->echoSuccessData($result);
    }

    /**
     * 获取集团活动评论列表
     */
    public function getGroupActivityCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_GROUP_ACTIVITY));
        $this->echoSuccessData($result);
    }

    /**
     * 获取集团新闻评论列表
     */
    public function getGroupNewsCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_GROUP_NEWS));
        $this->echoSuccessData($result);
    }

    /**
     * 获取集团通知评论列表
     */
    public function getGroupNoticCommentListAction() {
        $result = $this->getCommentList(array('datatype' => Enum_Comment::COMMENT_TYPE_GROUP_NOTICE));
        $this->echoSuccessData($result);
    }

}
