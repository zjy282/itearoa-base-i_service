<?php

/**
 * 用户结果转换器
 */
class Convertor_User extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 用户信息转换器
     *
     * @param array $list
     *            用户信息
     * @return array
     */
    public function userInfoConvertor($list) {
        $data = array();
        $hotelModel = new HotelListModel();
        $hotelInfo = $hotelModel->getHotelListDetail($list['hotelid']);
        $userModel = new UserModel();
        $platformNameList = Enum_Platform::getPlatformNameList();
        $data ['id'] = $list ['id'];
        $data ['hotelid'] = $list ['hotelid'];
        $data ['groupid'] = $list ['groupid'];
        $data ['serviceUrl'] = $userModel->getGsmRedirect(array(
            'PropertyInterfID' => $hotelInfo['propertyinterfid'],
            'CustomerID' => $list['oid'],
            'Room' => $list['room_response'],
            'LastName' => $list['lastname_response'],
            'groupid' => $list ['groupid'],
        ));
        $data ['oid'] = $list ['oid'];
        $data ['createtime'] = $list ['createtime'];
        $data ['lastlogintime'] = $list ['lastlogintime'];
        $data ['lastloginip'] = Util_Tools::ntoip($list ['lastloginip']);
        $data ['platform'] = $list ['platform'];
        $data ['platformName'] = $platformNameList [$list ['platform']];
        $data ['identity'] = $list ['identity'];
        $data ['language'] = $list ['language'];
        $data ['token'] = $list ['token'];
        return $data;
    }

    /**
     * 用户信息列表
     *
     * @param array $list
     *            用户信息列表
     * @param int $count
     *            用户总数
     * @param array $param
     *            扩展字段
     * @return array
     */
    public function getUserListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $groupIdList = array_column($list, 'groupid');
        if ($groupIdList) {
            $groupModel = new GroupModel ();
            $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
            $groupNameList = array_column($groupInfoList, 'name', 'id');
        }
        $hotelIdList = array_column($list, 'hotelid');
        if ($hotelIdList) {
            $hotelListModel = new HotelListModel ();
            $hotelInfoList = $hotelListModel->getHotelListList(array('id' => $hotelIdList));
            $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');
        }
        $platformNameList = Enum_Platform::getPlatformNameList();
        $languageNameList = Enum_Lang::getLangNameList();
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['room_no'] = $value ['room_no'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['hotelName'] = $hotelNameList [$oneTemp ['hotelid']];
            $oneTemp ['groupid'] = $value ['groupid'];
            $oneTemp ['groupName'] = $groupNameList [$oneTemp ['groupid']];
            $oneTemp ['oid'] = $value ['oid'];
            $oneTemp ['fullname'] = $value ['fullname'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['lastlogintime'] = $value ['lastlogintime'];
            $oneTemp ['lastloginip'] = $value ['lastloginip'];
            $oneTemp ['platform'] = $value ['platform'];
            $oneTemp ['platformName'] = $platformNameList [$oneTemp ['platform']];
            $oneTemp ['identity'] = $value ['identity'];
            $oneTemp ['language'] = $value ['language'];
            $oneTemp ['languageName'] = $languageNameList [$oneTemp ['language']];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * @param $list
     * @param $count
     * @param $param
     * @return array
     */
    public function getSignListConvertor($list, $count, $param)
    {
        $data = array('list' => $list);
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}