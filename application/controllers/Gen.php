<?php

class GenController extends \BaseController {

    public function init() {
	   // parent::init();
    }

    public function indexAction(){
        echo 11111;exit;
    }

    public function genClassAction() {
        $genModel = new GenModel();
        $genModel->genClass(array());
    }
}
