<?php
class Push_Umeng_IOSUnicast extends Push_Umeng_IOSNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "unicast";
        $this->data["device_tokens"] = NULL;
    }
}
