<?php

/**
 * 活动报名转换器类
 */
class Convertor_GroupActivityOrder extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 活动报名列表数据转换器
     *
     * @param array $list
     *            活动报名列表数据
     * @param int $count
     *            活动报名列表数据总数
     * @param array $param
     *            扩展参数
     * @return multitype:multitype: array
     */
    public function getActivityOrderListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $groupIdList = array_column($list, 'groupid');
        $groupModel = new GroupModel ();
        $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
        $groupNameList = array_column($groupInfoList, 'name', 'id');
        $activityIdList = array_column($list, 'activityid');
        $activityModel = new GroupActivityModel();
        $activityInfoList = $activityModel->getActivityList(array('id' => $activityIdList));
        $activityNameList = array_column($activityInfoList, 'title', 'id');
        $userIdList = array_column($list, 'userid');
        if ($userIdList) {
            $userModel = new UserModel ();
            $userInfoList = $userModel->getUserList(array('id' => $userIdList));
            $userNameList = array_column($userInfoList, 'fullname', 'id');
        }
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['userid'] = $value ['userid'];
            $oneTemp ['userName'] = $userNameList [$oneTemp ['userid']];
            $oneTemp ['name'] = $value ['name'];
            $oneTemp ['phone'] = $value ['phone'];
            $oneTemp ['createtime'] = $value ['creattime'];
            $oneTemp ['groupid'] = $value ['groupid'];
            $oneTemp ['remark'] = $value ['remark'];
            $oneTemp ['orderCount'] = $value ['ordercount'];
            $oneTemp ['groupName'] = $groupNameList [$oneTemp ['groupid']];
            $oneTemp ['activityid'] = $value ['activityid'];
            $oneTemp ['activityName'] = $activityNameList [$oneTemp ['activityid']];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
