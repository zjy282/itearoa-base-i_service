<?php

/**
 * Pusht推送convertor
 * @author ZXM
 */
class Convertor_Push extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function gsmPushMsgConvertor($pushResult) {
        return array(
            'result' => $pushResult
        );
    }

    public function getPushListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['type'] = $value['type'];
            $oneTemp['dataid'] = $value['dataid'];
            $oneTemp['cn_title'] = $value['cn_title'];
            $oneTemp['en_title'] = $value['en_title'];
            $oneTemp['url'] = $value['url'];
            $oneTemp['result'] = $value['result'];
            $oneTemp['createtime'] = $value['createtime'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}