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
}