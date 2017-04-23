<?php

class Push_Umeng_AndroidUnicast extends Push_Umeng_AndroidNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "unicast";
        $this->data["device_tokens"] = NULL;
    }
}
