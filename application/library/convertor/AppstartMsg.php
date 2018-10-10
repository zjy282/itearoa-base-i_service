<?php

/**
 * APP启动消息转换器类
 */
class Convertor_AppstartMsg extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 可用的app启动消息结果转换器
     *
     * @param array $msgList
     *            可用的app启动消息
     * @param array $msgLogHistoryMsgId
     *            消息日志id
     * @return array
     */
    public function getEffectiveAppStartMsgConvertor($msgList, $msgLogHistoryMsgId) {
        $msgList = array_column($msgList, null, 'id');
        $effectiveMsgList = array_diff_key($msgList, array_flip($msgLogHistoryMsgId));
        krsort($effectiveMsgList);

        $data = array('list' => array());
        foreach ($effectiveMsgList as $effectiveMsg) {
            $dataTemp ['msgId'] = $effectiveMsg ['id'];
            $dataTemp ['pic'] = Enum_Img::getPathByKeyAndType($effectiveMsg ['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750);
            $dataTemp ['msg'] = $effectiveMsg ['msg'];
            $dataTemp ['url'] = $effectiveMsg ['url'];
            $data ['list'] [] = $dataTemp;
        }
        return $data;
    }

    /**
     * app启动消息结果转换器
     *
     * @param array $list
     *            app启动消息数据
     * @param int $count
     *            app启动消息数据总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getAppstartMsgListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $hotelIdList = $groupIdList = array();
        foreach ($list as $dataOne) {
            if ($dataOne ['type'] == 1) {
                $hotelIdList [] = $dataOne ['dataid'];
            } else {
                $groupIdList [] = $dataOne ['dataid'];
            }
        }
        $hotelListModel = new HotelListModel ();
        $hotelInfoList = $hotelListModel->getHotelListList(array('id' => $hotelIdList));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');
        $hotelGroupIdList = array_column($hotelInfoList, 'groupid', 'id');
        $groupIdList = array_unique(array_merge($groupIdList, $hotelGroupIdList));
        $groupModel = new GroupModel ();
        $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
        $groupNameList = array_column($groupInfoList, 'name', 'id');
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['type'] = $value ['type'];
            $oneTemp ['dataid'] = $value ['dataid'];
            if ($oneTemp ['type'] == 1) {
                $oneTemp ['dataName'] = $hotelNameList [$oneTemp ['dataid']] . "（{$groupNameList[$hotelGroupIdList[$oneTemp['dataid']]]}）";
            } else {
                $oneTemp ['dataName'] = $groupNameList [$oneTemp ['dataid']];
            }
            $oneTemp ['pic'] = $value ['pic'];
            $oneTemp ['msg'] = $value ['msg'];
            $oneTemp ['url'] = $value ['url'];
            $oneTemp ['status'] = $value ['status'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}