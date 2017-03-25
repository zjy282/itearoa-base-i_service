<?php

/**
 * 用户入住历史convertor
 * @author ZXM
 */
class Convertor_UserHistory extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function userHistoryListConvertor($list) {
        $data = array(
            'list' => array()
        );
        foreach ($list as $history) {
            $historyTemp = array();
            $historyTemp['id'] = $history['id'];
            $historyTemp['userid'] = $history['userid'];
            $historyTemp['hotelid'] = $history['hotelid'];
            $historyTemp['groupid'] = $history['groupid'];
            $historyTemp['checkin'] = $history['checkin'];
            $historyTemp['checkout'] = $history['checkout'];
            $data['list'][] = $historyTemp;
        }
        return $data;
    }
}