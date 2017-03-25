<?php

/**
 * 雅士阁生活类型convertor
 * @author ZXM
 */
class Convertor_LifeType extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getLifeTypeListConvertor($list) {
        $data = array();
        $data['list'] = array();
        foreach ($list as $type){
            $typeTemp = array();
            $typeTemp['id'] = $type['id'];
            $typeTemp['title'] = $this->handlerMultiLang('title', $type);
            $data['list'][] = $typeTemp;
        }
        return $data;
    }
}