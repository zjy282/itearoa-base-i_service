<?php

class Convertor_HotelAdministrator extends Convertor_Base {
    public function __construct() {
        parent::__construct();
    }

    /**
     * 物业管理员列表数据转换器
     * @param array $list
     * @return array
     */
    public function getHotelAdministratorListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        $hotelIdList = array_column($list, 'hotelid');
        $hotelModel = new HotelListModel();
        $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdList));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');

        $groupIdList = array_column($hotelInfoList, 'groupid', 'id');
        $groupModel = new GroupModel();
        $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
        $groupNameList = array_column($groupInfoList, 'name', 'id');

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['userName'] = $value['username'];
            $oneTemp['realName'] = $value['realname'];
            $oneTemp['status'] = $value['status'];
            $oneTemp['remark'] = $value['remark'];
            $oneTemp['lastLoginTime'] = $value['lastlogintime'];
            $oneTemp['lastLoginIp'] = $value['lastloginip'];
            $oneTemp['createTime'] = $value['createtime'];
            $oneTemp['createAdmin'] = $value['createAdmin'];
            $oneTemp['hotelId'] = $value['hotelid'];
            $oneTemp['hotelName'] = $hotelNameList[$value['hotelid']];
            $oneTemp['groupId'] = $groupIdList[$value['hotelid']];
            $oneTemp['groupName'] = $groupNameList[$oneTemp['groupId']];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }

    /**
     * 集团管理员详情数据转换器
     * @param array $result
     * @return array
     */
    public function getHotelAdministratorDetailConvertor($result) {
        $data = array();

        if (is_array($result) && count($result) > 0) {
            $data ['id'] = $result['id'];
            $data ['userName'] = $result['username'];
            $data ['realName'] = $result['realname'];
            $data ['remark'] = $result['remark'];
            $data ['status'] = $result['status'];
            $data ['lastLoginTime'] = $result['lastlogintime'];
            $data ['lastLoginIp'] = $result['lastloginip'];
            $data ['createTime'] = $result['createtime'];
            $data ['createAdmin'] = $result['createadmin'];
            $data ['groupId'] = $result['groupid'];
        }

        return $data;
    }
} 
