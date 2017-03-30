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
}
