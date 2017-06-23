<?php

/**
 * 房型转换器
 */
class Convertor_RoomType extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 房型列表
     *
     * @param array $list
     *            房型列表
     * @param int $count
     *            房型总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getRoomtypeListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['size'] = $value ['size'];
            $oneTemp ['title_lang1'] = $value ['title_lang1'];
            $oneTemp ['title_lang2'] = $value ['title_lang2'];
            $oneTemp ['title_lang3'] = $value ['title_lang3'];
            $oneTemp ['panoramic'] = $value ['panoramic'];
            $oneTemp ['roomCount'] = $value ['roomcount'];
            $oneTemp ['personCount'] = $value ['personcount'];
            $oneTemp ['bedtype_lang1'] = $value ['bedtype_lang1'];
            $oneTemp ['bedtype_lang2'] = $value ['bedtype_lang2'];
            $oneTemp ['bedtype_lang3'] = $value ['bedtype_lang3'];
            $oneTemp ['detail_lang1'] = $value ['detail_lang1'];
            $oneTemp ['detail_lang2'] = $value ['detail_lang2'];
            $oneTemp ['detail_lang3'] = $value ['detail_lang3'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['resid_list'] = $value ['resid_list'];
            $oneTemp ['pic'] = $value ['pic'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
