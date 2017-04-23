<?php
class Push_Umeng_IOSBroadcast extends Push_Umeng_IOSNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}
