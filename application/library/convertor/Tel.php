<?php

/**
 * 电话黄页convertor
 * @author ZXM
 */
class Convertor_Tel extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function hotelTelListConvertor($telTypeList, $telList) {
        $data = array(
            'list' => array()
        );
        
        $telListByType = array();
        foreach ($telList as $tel) {
            $telListByType[$tel['typeid']][] = array(
                'id' => $tel['id'],
                'title' => $this->handlerMultiLang('title', $tel),
                'tel' => $tel['tel']
            );
        }
        
        foreach ($telTypeList as $type) {
            $typeTemp = array();
            $typeTemp['id'] = $type['id'];
            $typeTemp['title'] = $this->handlerMultiLang('title', $type);
            $typeTemp['telList'] = $telListByType[$type['id']] ? $telListByType[$type['id']] : array();
            $data['list'][] = $typeTemp;
        }
        return $data;
    }
}