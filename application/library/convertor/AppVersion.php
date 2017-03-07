<?php

/**
 * APP版本convertor
 * @author ZXM
 */
class Convertor_AppVersion extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 根据设备获取APP最新的版本信息
     */
    public function lastAppVersionConvertor(array $result) {
        $data = array();
        $data['platform'] = $result['platform'];
        $data['platformName'] = Enum_Platform::getPlatformNameList()[$result['platform']];
        $data['forced'] = $result['forced'];
        $data['version'] = $result['version'];
        $data['description'] = $result['description'];
        $data['createtime'] = $result['createtime'];
        return $data;
    }
}