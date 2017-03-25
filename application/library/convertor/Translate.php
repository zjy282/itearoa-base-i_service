<?php

/**
 * 用户convertor
 * @author ZXM
 */
class Convertor_Translate extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function translateResultConvertor($list) {
        $data = array();
        $data['from'] = $list['from'];
        $data['to'] = $list['to'];
        $data['src'] = $list['trans_result'][0]['src'];
        $data['result'] = $list['trans_result'][0]['dst'];
        return $data;
    }
}