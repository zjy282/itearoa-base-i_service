<?php

/**
 * 雅士阁生活类型convertor
 * @author ZXM
 */
class Convertor_LifeType extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * lifetype结果转换器
     * @param array $list
     * @return array
     */
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

    /**
     * 管理端生活标签转换器
     * @param array $list
     * @param int $count
     * @param array $param
     * @return array
     */
    public function getAdminLifeTypeListConvertor($list,$count,$param) {
        $data = array();
        $data['list'] = array();
        foreach ($list as $type){
            $typeTemp = array();
            $typeTemp['id'] = $type['id'];
            $typeTemp['titleLang1'] = $type['title_lang1'];
            $typeTemp['titleLang2'] = $type['title_lang2'];
            $typeTemp['titleLang3'] = $type['title_lang3'];
            $data['list'][] = $typeTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
    
    public function getLifeTypeDetailConvertor($detail) {
    	$data = array();
    	$data['id'] = $detail['id'];
    	$data['title'] = $this->handlerMultiLang('title', $detail);
    	return $data;
    }
}
