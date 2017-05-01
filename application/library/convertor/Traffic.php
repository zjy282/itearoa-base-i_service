<?php

class Convertor_Traffic extends Convertor_Base {
    public function __construct() {
        parent::__construct();
    }

    public function getTrafficListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['introduct_lang1'] = $value['introduct_lang1'];
            $oneTemp['introduct_lang2'] = $value['introduct_lang2'];
            $oneTemp['introduct_lang3'] = $value['introduct_lang3'];
            $oneTemp['detail_lang1'] = $value['detail_lang1'];
            $oneTemp['detail_lang2'] = $value['detail_lang2'];
            $oneTemp['detail_lang3'] = $value['detail_lang3'];
            $oneTemp['hotelid'] = $value['hotelid'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}
