<?php

/**
 * 酒店问卷调查转换器类
 *
 */
class Convertor_Feedback extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 酒店问卷调查列表
     *
     * @param array $list
     *            酒店问卷调查列表
     * @return array
     */
    public function getFeedbackListConvertor($list) {
        $data = array();
        $data ['list'] = array();
        foreach ($list as $question) {
            $option = json_decode($question ['option'], true);
            $questionTemp = array();
            $questionTemp ['questionid'] = $question ['id'];
            $questionTemp ['type'] = $question ['type'];
            $questionTemp ['question'] = $question ['question'];
            $questionTemp ['option'] = $option ? $option : array();
            $data ['list'] [] = $questionTemp;
        }
        return $data;
    }

    /**
     * 后台酒店问卷调查列表
     * @param array $list 酒店问卷调查列表
     * @param int $count 酒店问卷调查列表总数
     * @param array $param 扩展参数
     * @return array
     */
    public function getListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $listIdList = array_column($list, 'listid');
        if ($listIdList) {
            $feedbackListModel = new FeedbackListModel();
            $feedbackList = $feedbackListModel->getFeedbackList(array('id' => $listIdList));
            $feedbackListNameList = array_column($feedbackList, 'name', 'id');
        }
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['question'] = $value ['question'];
            $oneTemp ['type'] = $value ['type'];
            $oneTemp ['option'] = $value ['option'];
            $oneTemp ['sort'] = $value ['sort'];
            $oneTemp ['status'] = $value ['status'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['listid'] = $value ['listid'];
            $oneTemp ['listName'] = $feedbackListNameList[$oneTemp ['listid']];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
