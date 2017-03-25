<?php

/**
 * 促销convertor
 * @author ZXM
 */
class Convertor_Promotion extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getPromotionListConvertor($promotionList, $tagList, $promotionCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew[$tag['id']] = $this->handlerMultiLang('title', $tag);
        }
        
        $data = array(
            'list' => array()
        );
        foreach ($promotionList as $news) {
            $newTemp = array();
            $newTemp['id'] = $news['id'];
            $newTemp['title'] = $this->handlerMultiLang('title', $news);
            $newTemp['article'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('article', $news));
            $newTemp['tagId'] = $news['tagid'];
            $newTemp['tagName'] = $tagListNew[$newTemp['tagId']];
            $newTemp['createtime'] = $news['createtime'];
            $newTemp['updatetime'] = $news['updatetime'];
            $data['list'][] = $newTemp;
        }
        $data['total'] = $promotionCount;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}