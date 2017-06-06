<?php

/**
 * 活动标签转换器类
 */
class Convertor_GroupActivityTag extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 活动标签列表数据转换器
     *
     * @param array $list
     *            活动标签列表数据
     * @param int $count
     *            活动标签列表数据总数
     * @param array $param
     *            扩展参数
     * @return multitype:multitype: array
     */
    public function getActivityTagListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $groupIdList = array_column($list, 'groupid');
        $groupModel = new GroupModel ();
        $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
        $groupNameList = array_column($groupInfoList, 'name', 'id');
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['title'] = $value ['title'];
            $oneTemp ['groupId'] = $value ['groupid'];
            $oneTemp ['groupName'] = $groupNameList [$value ['groupid']];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
