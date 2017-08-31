<?php

/**
 * 物业全景转换器类
 *
 */
class Convertor_Panoramic extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 物业全景列表
     *
     * @param array $list
     *            物业全景列表
     * @param int $count
     *            物业全景总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getPanoramicListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['panoramic'] = $value ['panoramic'];
            $oneTemp ['title_lang1'] = $value ['title_lang1'];
            $oneTemp ['title_lang2'] = $value ['title_lang2'];
            $oneTemp ['title_lang3'] = $value ['title_lang3'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['pic'] = $value ['pic'];
            $oneTemp ['status'] = $value ['status'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
