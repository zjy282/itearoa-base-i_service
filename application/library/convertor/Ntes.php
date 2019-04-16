<?php

/**
 * 网易云信转换器类
 */
class Convertor_Ntes extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取云信Token
     * @param $tokenInfo
     * @return array
     * @author zhangxm
     */
    public function getTokenConverter(array $tokenInfo) {
        $data['token'] = $tokenInfo['token'];
        return $data;
    }

    /**
     * 根据用户获取AccId
     * @param array $userList
     * @return array
     * @author zhangxm
     */
    public function getAccIdByUserConverter(array $userList) {
        $result = array();
        foreach ($userList as $userOne) {
            if (empty($userOne["ntes_accid"])) {
                continue;
            }
            $userOneTemp = array();
            $userOneTemp["room_no"] = $userOne["room_no"];
            $userOneTemp["fullname"] = $userOne["fullname"];
            $userOneTemp["accid"] = $userOne["ntes_accid"];
            $result[] = $userOneTemp;
        }
        return $result;
    }
}
