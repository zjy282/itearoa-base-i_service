<?php
class Push_Umeng_IOSListcast extends Push_Umeng_IOSNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "listcast";
        $this->data["device_tokens"] = NULL;
    }
}
