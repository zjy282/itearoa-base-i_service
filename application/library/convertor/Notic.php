<?php

/**
 * 通知convertor
 * @author ZXM
 */
class Convertor_Notic extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getNoticListConvertor($noticList, $tagList, $noticCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew[$tag['id']] = $this->handlerMultiLang('title', $tag);
        }
        
        $data = array(
            'list' => array()
        );
        foreach ($noticList as $notic) {
            $newTemp = array();
            $newTemp['id'] = $notic['id'];
            $newTemp['title'] = $this->handlerMultiLang('title', $notic);
            $newTemp['article'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('article', $notic));
            $newTemp['tagId'] = $notic['tagid'];
            $newTemp['tagName'] = $tagListNew[$newTemp['tagId']];
            $newTemp['createtime'] = $notic['createtime'];
            $newTemp['updatetime'] = $notic['updatetime'];
            $data['list'][] = $newTemp;
        }
        $data['total'] = $noticCount;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}