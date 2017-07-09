<?php

/**
 * 客房物品结果转换器
 */
class Convertor_RoomRes extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 客房物品类型列表
     *
     * @param array $list
     *            客房物品类型列表
     * @return array
     */
    public function hotelRoomTypeResListConvertor($list) {
        $data = array('list' => array());
        foreach ($list as $resOne) {
            $resTemp = array();
            $resTemp ['id'] = $resOne ['id'];
            $resTemp ['icon'] = $resOne ['icon'];
            $resTemp ['pic'] = Enum_Img::getPathByKeyAndType($resOne ['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750);
            $resTemp ['name'] = $this->handlerMultiLang('name', $resOne);
            $resTemp ['pdf'] = Enum_Img::getPathByKeyAndType($resOne ['pdf']);
            $resTemp ['video'] = Enum_Img::getPathByKeyAndType($resOne ['video']);
            $resTemp ['introduct'] = $this->handlerMultiLang('introduct', $resOne);
            $resTemp ['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $resOne));
            $data ['list'] [] = $resTemp;
        }
        return $data;
    }

    /**
     * 客房物品列表
     *
     * @param array $list
     *            客房物品列表
     * @param int $count
     *            客房物品总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getRoomResListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['icon'] = $value ['icon'];
            $oneTemp ['name_lang1'] = $value ['name_lang1'];
            $oneTemp ['name_lang2'] = $value ['name_lang2'];
            $oneTemp ['name_lang3'] = $value ['name_lang3'];
            $oneTemp ['pdf'] = $value ['pdf'];
            $oneTemp ['sort'] = $value ['sort'];
            $oneTemp ['video'] = $value ['video'];
            $oneTemp ['pic'] = $value ['pic'];
            $oneTemp ['introduct_lang1'] = $value ['introduct_lang1'];
            $oneTemp ['introduct_lang2'] = $value ['introduct_lang2'];
            $oneTemp ['introduct_lang3'] = $value ['introduct_lang3'];
            $oneTemp ['detail_lang1'] = $value ['detail_lang1'];
            $oneTemp ['detail_lang2'] = $value ['detail_lang2'];
            $oneTemp ['detail_lang3'] = $value ['detail_lang3'];
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
