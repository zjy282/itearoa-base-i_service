<?php

/**
 * 本地攻略convertor
 * @author ZXM
 */
class Convertor_Poi extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getPoiListConvertor($poiList, $poiCount, $param) {
        $data = array(
            'list' => array()
        );
        foreach ($poiList as $pois) {
            $poiTemp = array();
            $poiTemp['id'] = $pois['id'];
            $poiTemp['name'] = $this->handlerMultiLang('name', $pois);
            $poiTemp['address'] = $this->handlerMultiLang('address', $pois);
            $poiTemp['tel'] = $pois['tel'];
            $poiTemp['introduct'] = $this->handlerMultiLang('introduct', $pois);
            $poiTemp['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $pois));
            $poiTemp['lat'] = $pois['lat'];
            $poiTemp['lng'] = $pois['lng'];
            $data['list'][] = $poiTemp;
        }
        $data['total'] = $poiCount;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}