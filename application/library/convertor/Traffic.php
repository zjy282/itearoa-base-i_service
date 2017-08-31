<?php

/**
 * 酒店交通结果转换器
 *
 */
class Convertor_Traffic extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 酒店交通结果
     *
     * @param array $list
     *            酒店交通结果
     * @param int $count
     *            酒店交通总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getTrafficListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['introduct_lang1'] = $value ['introduct_lang1'];
            $oneTemp ['introduct_lang2'] = $value ['introduct_lang2'];
            $oneTemp ['introduct_lang3'] = $value ['introduct_lang3'];
            $oneTemp ['detail_lang1'] = $value ['detail_lang1'];
            $oneTemp ['detail_lang2'] = $value ['detail_lang2'];
            $oneTemp ['detail_lang3'] = $value ['detail_lang3'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['sort'] = $value ['sort'];
            $oneTemp ['pdf'] = $value ['pdf'];
            $oneTemp ['video'] = $value ['video'];
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
