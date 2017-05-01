<?php

class Convertor_Floor extends Convertor_Base {
    public function __construct() {
        parent::__construct();
    }

    public function getFloorListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['floor'] = $value['floor'];
            $oneTemp['detail_lang1'] = $value['detail_lang1'];
            $oneTemp['detail_lang2'] = $value['detail_lang2'];
            $oneTemp['detail_lang3'] = $value['detail_lang3'];
            $oneTemp['status'] = $value['status'];
            $oneTemp['hotelid'] = $value['hotelid'];
            $oneTemp['pic'] = $value['pic'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}
