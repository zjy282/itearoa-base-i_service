<?php

class IndexController extends \BaseController {

    public function init() {
	    parent::init();
    }

    public function indexAction() {
        $array = array('code' => 1,'data' => array ('name' => 'lihe','value'=>'liheinfo'));
        $this->echoJson($array);
    }
}
