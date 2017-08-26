<?php

/**
 * 电话黄页后台
 *
 */
class Convertor_TelType extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 电话黄页类型
     *
     * @param array $list
     *            电话黄页类型
     * @param int $count
     *            电话黄页类型总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getTelTypeListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['title_lang1'] = $value ['title_lang1'];
            $oneTemp ['title_lang2'] = $value ['title_lang2'];
            $oneTemp ['title_lang3'] = $value ['title_lang3'];
            $oneTemp ['islogin'] = $value ['islogin'];
            $oneTemp ['status'] = $value ['status'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
