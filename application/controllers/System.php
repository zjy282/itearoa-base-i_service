<?php

class SystemController extends \BaseController {

    public function init() {
        parent::init();
    }

    public function getTimeAction() {
        $this->echoSuccessData(array(
            'time' => time()
        ));
    }
}
