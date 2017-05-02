<?php

class Convertor_Feedback extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getFeedbackListConvertor($list) {
        $data = array();
        $data['list'] = array();

        foreach ($list as $question) {
            $option = json_decode($question['option'], true);
            $questionTemp = array();
            $questionTemp['questionid'] = $question['id'];
            $questionTemp['type'] = $question['type'];
            $questionTemp['question'] = $question['question'];
            $questionTemp['option'] = $option ? $option : array();
            $data['list'][] = $questionTemp;
        }
        return $data;
    }

    public function getListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['question'] = $value['question'];
            $oneTemp['type'] = $value['type'];
            $oneTemp['option'] = $value['option'];
            $oneTemp['sort'] = $value['sort'];
            $oneTemp['status'] = $value['status'];
            $oneTemp['hotelid'] = $value['hotelid'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}
