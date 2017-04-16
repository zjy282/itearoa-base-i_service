<?php

class Convertor_City extends Convertor_Base {
    public function __construct() {
        parent::__construct();
    }

    /**
     * iservice city列表数据转换器
     *
     * @param array $list
     * @return array
     */
    public function getCityListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['countryName'] = $value['countryname'];
            $oneTemp['countryEnName'] = $value['countryenname'];
            $oneTemp['name'] = $value['name'];
            $oneTemp['enname'] = $value['enname'];
            $oneTemp['code'] = $value['code'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }

}
