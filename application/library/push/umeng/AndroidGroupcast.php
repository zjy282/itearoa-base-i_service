<?php
class Push_Umeng_AndroidGroupcast extends Push_Umeng_AndroidNotification {

    function __construct() {
        parent::__construct();
        $this->data["type"] = "groupcast";
        $this->data["filter"] = NULL;
    }
}
