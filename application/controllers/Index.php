<?php

class IndexController extends \BaseController {

    public function init() {
	parent::init();
    }

    public function indexAction() {
        $this->_view->display('index/index.phtml');
    }
}
