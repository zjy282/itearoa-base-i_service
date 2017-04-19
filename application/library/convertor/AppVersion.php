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
        if ($result) {
            $data['platform'] = $result['platform'];
            $data['platformName'] = Enum_Platform::getPlatformNameList()[$result['platform']];
            $data['forced'] = $result['forced'];
            $data['version'] = $result['version'];
            $data['description'] = $result['description'];
            $data['createtime'] = $result['createtime'];
        }
        return $data;
    }

    public function getAppVersionListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['platform'] = $value['platform'];
            $oneTemp['forced'] = $value['forced'];
            $oneTemp['version'] = $value['version'];
            $oneTemp['description'] = $value['description'];
            $oneTemp['createtime'] = $value['createtime'];
            $oneTemp['latest'] = $value['latest'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}