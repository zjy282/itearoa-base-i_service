<?php

/**
 * promotion tag convertor
 * @author ZXM
 */
class Convertor_PromotionTag extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * tag结果转换器
     * @param array $list
     * @param int $count
     * @param array $param
     * @return array
     */
    public function getAdminTagListConvertor($list,$count,$param) {
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
    
    public function getTagDetailConvertor($detail) {
    	$data = array();
    	$data['id'] = $detail['id'];
    	$data['title_lang1'] = $detail['title_lang1'];
    	$data['title_lang2'] = $detail['title_lang2'];
    	$data['title_lang3'] = $detail['title_lang3'];
    	return $data;
    }
}
