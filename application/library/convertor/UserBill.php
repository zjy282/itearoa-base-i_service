<?php

/**
 * 用户账单结果转换器
 */
class Convertor_UserBill extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 后台用户账单信息列表
     *
     * @param array $list
     *            用户账单信息列表
     * @param int $count
     *            用户账单总数
     * @param array $param
     *            扩展字段
     * @return array
     */
    public function getUserBillListAdminConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['room_no'] = $value ['room_no'];
            $oneTemp ['name'] = $value ['name'];
            $oneTemp ['userid'] = $value ['userid'];
            $oneTemp ['pdf'] = $value ['pdf'];
            $oneTemp ['date'] = $value ['date'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['updatetime'] = $value ['updatetime'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param['page'];
        $data ['limit'] = $param['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 用户账单信息列表
     *
     * @param array $list
     *            用户账单信息列表
     * @param int $count
     *            用户账单总数
     * @param array $param
     *            扩展字段
     * @return array
     */
    public function getUserBillListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $hotelIdlist = array_column($list, 'hotelid');
        $hotelModel = new HotelListModel();
        $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdlist));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['hotelName'] = $hotelNameList[$value ['hotelid']];
            $oneTemp ['room_no'] = $value ['room_no'];
            $oneTemp ['name'] = $value ['name'];
            $oneTemp ['userid'] = $value ['userid'];
            $oneTemp ['pdf'] = Enum_Img::getPathByKeyAndType($value['pdf']);
            $oneTemp ['date'] = date('Y-m-d', $value['date']);
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['updatetime'] = $value ['updatetime'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}