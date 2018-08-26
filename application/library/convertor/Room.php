<?php

/**
 * 客房结果转换器
 */
class Convertor_Room extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 客房列表
     *
     * @param array $list
     *            客房列表
     * @param int $count
     *            客房总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getRoomListConvertor($list, $count, $param) {
        $data = array('list' => array());

        $floorIdList = array_column($list, 'floor');
        if ($floorIdList) {
            $floorModel = new FloorModel();
            $floorList = $floorModel->getFloorList(array('id' => $floorIdList));
            $floorNameList = array_column($floorList, 'floor', 'id');
        }
        $typeIdList = array_column($list, 'typeid');
        if ($typeIdList) {
            $roomTypeModel = new RoomtypeModel();
            $roomTypeList = $roomTypeModel->getRoomtypeList(array('id' => $typeIdList));
            $roomTypeNameList = array_column($roomTypeList, 'title_lang1', 'id');
        }
        $roomIdList = array_column($list, 'room');
        if ($roomIdList) {
            $userModel = new UserModel();
            $userInfoList = $userModel->getUserList(array('hotelid' => $param['hotelid'], 'room_no' => $roomIdList));
            $userInfoList = array_column($userInfoList, null, 'room_no');
        }

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['floor'] = $value ['floor'];
            $oneTemp ['floorName'] = $floorNameList[$oneTemp ['floor']];
            $oneTemp ['typeId'] = $value ['typeid'];
            $oneTemp ['typeName'] = $roomTypeNameList[$oneTemp ['typeId']];
            $oneTemp ['hotelId'] = $value ['hotelid'];
            $oneTemp ['size'] = $value ['size'];
            $oneTemp ['room'] = $value ['room'];
            $oneTemp ['createTime'] = $value ['createtime'];
            $oneTemp ['lastUser'] = $userInfoList[$value['room']];
            $data ['list'] [] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param ['page'];
        $data['limit'] = $param ['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}
