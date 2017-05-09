<?php

class Rpc_Gsm {

    private function __construct() {
    }

    public function send($groupId, $interface, $params) {
        $groupModel = new GroupModel();
        $groupPort = $groupModel->getGroupPortByGroupId($groupId);
        if (empty($groupPort)) {
            return array(
                'code' => 1,
                'msg' => 'GSM接口地址获取失败'
            );
        }


    }
}