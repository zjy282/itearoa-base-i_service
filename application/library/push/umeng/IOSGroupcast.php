<?php
class Push_Umeng_IOSGroupcast extends Push_Umeng_IOSNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "groupcast";
        $this->data["filter"] = NULL;
    }
}
