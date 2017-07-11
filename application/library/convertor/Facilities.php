<?php

/**
 * 酒店设施转换器类
 *
 */
class Convertor_Facilities extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 酒店设施数据列表转换器
     *
     * @param array $list
     *            酒店设施数据
     * @param int $count
     *            酒店设施数据总数
     * @param array $param
     *            扩展参数
     * @return multitype:multitype: unknown number
     */
    public function getFacilitiesListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['icon'] = $value ['icon'];
            $oneTemp ['name_lang1'] = $value ['name_lang1'];
            $oneTemp ['name_lang2'] = $value ['name_lang2'];
            $oneTemp ['name_lang3'] = $value ['name_lang3'];
            $oneTemp ['detail_lang1'] = $value ['detail_lang1'];
            $oneTemp ['detail_lang2'] = $value ['detail_lang2'];
            $oneTemp ['detail_lang3'] = $value ['detail_lang3'];
            $oneTemp ['status'] = $value ['status'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['introduct_lang1'] = $value ['introduct_lang1'];
            $oneTemp ['introduct_lang2'] = $value ['introduct_lang2'];
            $oneTemp ['introduct_lang3'] = $value ['introduct_lang3'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['pdf'] = $value ['pdf'];
            $oneTemp ['video'] = $value ['video'];
            $oneTemp ['pic'] = $value ['pic'];
            $oneTemp ['sort'] = $value ['sort'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
