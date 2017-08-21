<?php

/**
 * 集团信息控制器类
 */
class Convertor_Group extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 集团信息列表数据转换器
     *
     * @param unknown $list
     *            集团信息列表数据
     * @param unknown $count
     *            集团信息总数
     * @param unknown $param
     *            扩展参数
     * @return array
     */
    public function getGroupListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['name'] = $value ['name'];
            $oneTemp ['enname'] = $value ['enname'];
            $oneTemp ['port_url'] = $value ['port_url'];
            $oneTemp ['about_zh'] = $value ['about_zh'];
            $oneTemp ['about_en'] = $value ['about_en'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 集团详情数据转换器
     *
     * @param array $result
     *            集团详情
     * @return array
     */
    public function getGroupDetailConvertor($result) {
        $data = array();
        if (is_array($result) && count($result) > 0) {
            $langInfo = Yaf_Registry::get('hotelLangInfo');
            $data ['id'] = $result ['id'];
            $data ['name'] = $result ['name'];
            $data ['enName'] = $result ['enname'];
            $data ['portUrl'] = $result ['port_url'];
            $data ['about'] = Enum_Img::getPathByKeyAndType($langInfo['lang'] == 'en' ? $result ['about_en'] : $result ['about_zh']);
        }
        return $data;
    }

    /**
     * 后台集团详情数据转换器
     *
     * @param array $result
     *            集团详情
     * @return array
     */
    public function getAdminGroupDetailConvertor($result) {
        $data = array();
        if (is_array($result) && count($result) > 0) {
            $langInfo = Yaf_Registry::get('hotelLangInfo');
            $data ['id'] = $result ['id'];
            $data ['name'] = $result ['name'];
            $data ['enName'] = $result ['enname'];
            $data ['portUrl'] = $result ['port_url'];
            $data ['about_zh'] = $result ['about_zh'];
            $data ['about_en'] = $result ['about_en'];
        }
        return $data;
    }
}
