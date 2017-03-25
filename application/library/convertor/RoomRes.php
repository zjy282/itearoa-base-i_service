<?php

/**
 * 客房物品convertor
 * @author ZXM
 */
class Convertor_RoomRes extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function hotelRoomTypeResListConvertor($list) {
        $data = array(
            'list' => array()
        );
        foreach ($list as $resOne) {
            $resTemp = array();
            $resTemp['id'] = $resOne['id'];
            $resTemp['icon'] = $resOne['icon'];
            $resTemp['name'] = $this->handlerMultiLang('name', $resOne);
            $resTemp['pdf'] = Enum_Img::getPathByKeyAndType($resOne['pdf']);
            $resTemp['introduct'] = $this->handlerMultiLang('introduct', $resOne);
            $resTemp['detail'] = $this->handlerMultiLang('detail', $resOne);
            $data['list'][] = $resTemp;
        }
        return $data;
    }
}