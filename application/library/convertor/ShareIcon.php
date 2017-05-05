<?php

class Convertor_ShareIcon extends Convertor_Base {
    public function __construct() {
        parent::__construct();
    }

    public function getShareIconListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['key'] = $value['key'];
            $oneTemp['sort'] = $value['sort'];
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
