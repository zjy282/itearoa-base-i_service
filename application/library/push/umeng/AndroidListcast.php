<?php

class Push_Umeng_AndroidListcast extends Push_Umeng_AndroidNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "listcast";
        $this->data["device_tokens"] = NULL;
    }
}
