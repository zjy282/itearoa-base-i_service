<?php

/**
 * 员工结果转换器
 */
class Convertor_Staff extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 员工信息
     *
     * @param array $list
     *            员工信息
     * @return array
     */
    public function userInfoConvertor($list) {
        $data = array();
        $platformNameList = Enum_Platform::getPlatformNameList();
        $data ['id'] = $list ['id'];
        $data ['hotelid'] = $list ['hotelid'];
        $data ['groupid'] = $list ['groupid'];
        $data ['staffid'] = $list ['staffid'];
        $data ['createtime'] = $list ['createtime'];
        $data ['lastlogintime'] = $list ['lastlogintime'];
        $data ['lastloginip'] = Util_Tools::ntoip($list ['lastloginip']);
        $data ['platform'] = $list ['platform'];
        $data ['platformName'] = $platformNameList [$list ['platform']];
        $data ['identity'] = $list ['identity'];
        $data ['token'] = $list ['token'];
        $staffModel = new StaffModel();
        $data ['serviceUrl'] = $staffModel->getGsmRedirect(array(
            'StaffID' => $data['staffid']
        ));
        return $data;
    }
}