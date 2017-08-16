<?php

/**
 * Push推送结果转换器
 */
class Convertor_Push extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 推送结果
     *
     * @param array $pushResult
     *            推送结果
     * @return multitype:unknown
     */
    public function gsmPushMsgConvertor($pushResult) {
        return array('result' => $pushResult);
    }

    /**
     * 推送结果列表
     *
     * @param array $list
     *            推送结果列表
     * @param int $count
     *            推送结果总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getPushListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['type'] = $value ['type'];
            $oneTemp ['dataid'] = $value ['dataid'];
            $oneTemp ['cn_title'] = $value ['cn_title'];
            $oneTemp ['en_title'] = $value ['en_title'];
            $oneTemp ['content_type'] = $value ['content_type'];
            $oneTemp ['content_value'] = $value ['content_value'];
            $oneTemp ['result'] = $value ['result'];
            $oneTemp ['platform'] = $value ['platform'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 用户推送结果列表
     *
     * @param array $list
     *            推送结果列表
     * @param int $count
     *            推送结果总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function userMsgListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $langInfo = Yaf_Registry::get('hotelLangInfo');
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['userId'] = $value ['dataid'];
            $oneTemp ['title'] = $langInfo['lang'] == 'zh' ? $value ['cn_title'] : $value ['en_title'];
            $oneTemp ['value'] = $langInfo['lang'] == 'zh' ? $value ['cn_value'] : $value ['en_value'];
            $oneTemp ['url'] = $value ['content_value'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}