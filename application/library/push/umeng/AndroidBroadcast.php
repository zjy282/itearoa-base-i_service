<?php

class Push_Umeng_AndroidBroadcast extends Push_Umeng_AndroidNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}
