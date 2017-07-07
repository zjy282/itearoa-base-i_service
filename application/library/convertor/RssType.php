<?php

/**
 * RSS类型转换器类
 */
class Convertor_RssType extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * RSS类型转换器
     *
     * @param array $list
     *            POI标签
     * @param int $count
     *            POI标签总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getRssTypeListConvertor($list, $count, $param) {
        $data = array();
        $data ['list'] = array();
        foreach ($list as $type) {
            $typeTemp = array();
            $typeTemp ['id'] = $type ['id'];
            $typeTemp ['title'] = $type ['title'];
            $typeTemp ['title_en'] = $type ['title_en'];
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}