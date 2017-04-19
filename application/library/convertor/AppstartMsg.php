<?php

/**
 * APP启动消息convertor
 * @author ZXM
 */
class Convertor_AppstartMsg extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getEffectiveAppStartMsgConvertor($msgList, $msgLogHistoryMsgId) {
        $msgList = array_column($msgList, null, 'id');
        $effectiveMsgList = array_diff_key($msgList, array_flip($msgLogHistoryMsgId));
        krsort($effectiveMsgList);
        $effectiveMsg = current($effectiveMsgList);
        $data = array(
            'list' => array()
        );
        if ($effectiveMsg) {
            $dataTemp['msgId'] = $effectiveMsg['id'];
            $dataTemp['pic'] = Enum_Img::getPathByKeyAndType($effectiveMsg['pic']);
            $dataTemp['msg'] = $effectiveMsg['msg'];
            $dataTemp['url'] = $effectiveMsg['url'];
            $data['list'][] = $dataTemp;
        }

        return $data;
    }

    public function getAppstartMsgListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        $hotelIdList = $groupIdList = array();
        foreach ($list as $dataOne) {
            if ($dataOne['type'] == 1) {
                $hotelIdList[] = $dataOne['dataid'];
            } else {
                $groupIdList[] = $dataOne['dataid'];
            }
        }

        $hotelListModel = new HotelListModel();
        $hotelInfoList = $hotelListModel->getHotelListList(array('id' => $hotelIdList));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');
        $hotelGroupIdList = array_column($hotelInfoList, 'groupid', 'id');

        $groupIdList = array_unique(array_merge($groupIdList, $hotelGroupIdList));
        $groupModel = new GroupModel();
        $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
        $groupNameList = array_column($groupInfoList, 'name', 'id');

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['type'] = $value['type'];
            $oneTemp['dataid'] = $value['dataid'];
            if ($oneTemp['type'] == 1) {
                $oneTemp['dataName'] = $hotelNameList[$oneTemp['dataid']] . "（{$groupNameList[$hotelGroupIdList[$oneTemp['dataid']]]}）";
            } else {
                $oneTemp['dataName'] = $groupNameList[$oneTemp['dataid']];
            }
            $oneTemp['pic'] = $value['pic'];
            $oneTemp['msg'] = $value['msg'];
            $oneTemp['url'] = $value['url'];
            $oneTemp['status'] = $value['status'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}