<?php

/**
 * 活动结果转换器类
 */
class Convertor_Activity extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 可用活动列表转换器
     *
     * @param array $activityList
     *            活动列表数据
     * @param array $tagList
     *            活动标签数据
     * @param int $activityCount
     *            活动列表数据总数
     * @param array $param
     *            扩展参数
     * @return multitype:multitype: array
     */
    public function getEffectiveActivityListConvertor($activityList, $tagList, $activityCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew [$tag ['id']] = $this->handlerMultiLang('title', $tag);
        }
        $data = array('list' => array());
        foreach ($activityList as $activity) {
            $activityTemp = array();
            $activityTemp ['id'] = $activity ['id'];
            $activityTemp ['title'] = $this->handlerMultiLang('title', $activity);
            $activityTemp ['article'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('article', $activity));
            $activityTemp ['pdf'] = $activity['pdf'] ? Enum_Img::getPathByKeyAndType($activity['pdf']) : '';
            $activityTemp ['video'] = $activity['video'] ? Enum_Img::getPathByKeyAndType($activity['video']) : '';
            $activityTemp ['tagId'] = $activity ['tagid'];
            $activityTemp ['pic'] = $activity ['pic'];
            $activityTemp ['fromdate'] = $activity ['fromdate'];
            $activityTemp ['todate'] = $activity ['todate'];
            $activityTemp ['ordercount'] = $activity ['ordercount'];
            $activityTemp ['tagName'] = $tagListNew [$activityTemp ['tagId']];
            $activityTemp ['createtime'] = $activity ['createtime'];
            $activityTemp ['updatetime'] = $activity ['updatetime'];
            $activityTemp ['pic'] = Enum_Img::getPathByKeyAndType($activity ['pic']);
            $activityTemp ['pdf'] = Enum_Img::getPathByKeyAndType($activity ['pdf']);
            $activityTemp ['video'] = Enum_Img::getPathByKeyAndType($activity ['video']);
            $activityTemp ['fromdate'] = $activity ['fromdate'];
            $activityTemp ['todate'] = $activity ['todate'];
            $activityTemp ['count'] = $activity ['count'];
            $data ['list'] [] = $activityTemp;
        }
        $data ['total'] = $activityCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 后台活动列表转换器
     *
     * @param array $list
     *            活动列表数据
     * @param int $count
     *            活动列表数据总数
     * @param array $param
     *            扩展参数
     * @return multitype:multitype: array
     */
    public function getActivityListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $hotelIdlist = array_column($list, 'hotelid');
        $hotelModel = new HotelListModel ();
        $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdlist));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');
        $groupIdList = array_column($list, 'groupid');
        $groupModel = new GroupModel ();
        $groupInfoList = $groupModel->getGroupList(array('id' => $groupIdList));
        $groupNameList = array_column($groupInfoList, 'name', 'id');
        $tagidList = array_column($list, 'tagid');
        if ($tagidList) {
            $activityTagModel = new ActivityTagModel ();
            $activityTagList = $activityTagModel->getActivityTagList(array('id' => $tagidList));
            $activityTagNameList = array_column($activityTagList, 'title_lang1', 'id');
        }
        foreach ($list as $key => $value) {
            $activityTemp = array();
            $activityTemp ['id'] = $value ['id'];
            $activityTemp ['title_lang1'] = $value ['title_lang1'];
            $activityTemp ['title_lang2'] = $value ['title_lang2'];
            $activityTemp ['title_lang3'] = $value ['title_lang3'];
            $activityTemp ['article_lang1'] = $value ['article_lang1'];
            $activityTemp ['article_lang2'] = $value ['article_lang2'];
            $activityTemp ['article_lang3'] = $value ['article_lang3'];
            $activityTemp ['pic'] = $value ['pic'];
            $activityTemp ['fromdate'] = $value ['fromdate'];
            $activityTemp ['todate'] = $value ['todate'];
            $activityTemp ['ordercount'] = $value ['ordercount'];
            $activityTemp ['hotelid'] = $value ['hotelid'];
            $activityTemp ['hotelName'] = $hotelNameList [$activityTemp ['hotelid']];
            $activityTemp ['groupid'] = $value ['groupid'];
            $activityTemp ['groupName'] = $groupNameList [$activityTemp ['groupid']];
            $activityTemp ['status'] = $value ['status'];
            $activityTemp ['createtime'] = $value ['createtime'];
            $activityTemp ['updatetime'] = $value ['updatetime'];
            $activityTemp ['tagid'] = $value ['tagid'];
            $activityTemp ['tagName'] = $activityTagNameList [$activityTemp ['tagid']];
            $activityTemp ['sort'] = $value ['sort'];
            $activityTemp ['pdf'] = $value ['pdf'];
            $activityTemp ['video'] = $value ['video'];
            $activityTemp ['pic'] = $value ['pic'];
            $activityTemp ['fromdate'] = $value ['fromdate'];
            $activityTemp ['todate'] = $value ['todate'];
            $activityTemp ['count'] = $value ['count'];
            $data ['list'] [] = $activityTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
