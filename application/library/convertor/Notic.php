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
    
    public function getAdminNoticListConvertor($noticList, $tagList, $noticCount, $param) {
    	$tagListNew = array ();
    	foreach ( $tagList as $tag ) {
    		$tagListNew [$tag ['id']] ['titleLang1'] = $tag ['title_lang1'];
    		$tagListNew [$tag ['id']] ['titleLang2'] = $tag ['title_lang2'];
    		$tagListNew [$tag ['id']] ['titleLang3'] = $tag ['title_lang3'];
    	}
    	$data = array ('list' => array () );
    	foreach ( $noticList as $notic ) {
    		$noticTemp = array ();
    		$noticTemp ['id'] = $notic ['id'];
    		$noticTemp ['titleLang1'] = $notic ['title_lang1'];
    		$noticTemp ['titleLang2'] = $notic ['title_lang2'];
    		$noticTemp ['titleLang3'] = $notic ['title_lang3'];
    		$noticTemp ['articleLang1'] = Enum_Img::getPathByKeyAndType ( $notic ['article_lang1'] );
    		$noticTemp ['articleLang2'] = Enum_Img::getPathByKeyAndType ( $notic ['article_lang2'] );
    		$noticTemp ['articleLang3'] = Enum_Img::getPathByKeyAndType ( $notic ['article_lang3'] );
    		$noticTemp ['tagId'] = $notic ['tagid'];
    		$noticTemp ['tagName_lang1'] = $tagListNew [$noticTemp ['tagId']] ['title_lang1'];
    		$noticTemp ['tagName_lang2'] = $tagListNew [$noticTemp ['tagId']] ['title_lang2'];
    		$noticTemp ['tagName_lang3'] = $tagListNew [$noticTemp ['tagId']] ['title_lang3'];
    		$noticTemp ['createtime'] = $notic ['createtime'];
    		$noticTemp ['updatetime'] = $notic ['updatetime'];
    		$data ['list'] [] = $noticTemp;
    	}
    	$data ['total'] = $noticCount;
    	$data ['page'] = $param ['page'];
    	$data ['limit'] = $param ['limit'];
    	$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
    	return $data;
    }
    
    public function getNoticDetailConvertor($list) {
    	$data = array ();
    	$data ['id'] = $list ['id'];
    	$data ['title'] = $this->handlerMultiLang ( 'title', $list );
    	$data ['article'] = Enum_Img::getPathByKeyAndType ( $this->handlerMultiLang ( 'article', $list ) );
    	$data ['createTime'] = $list ['createtime'];
    	$data ['updateTime'] = $list ['updatetime'];
    	$data ['status'] = $list ['status'];
    	$data ['tagId'] = $list ['tagid'];
    	return $data;
    }
    
    public function getAdminNoticDetailConvertor($list) {
    	$data = array ();
    	$data ['id'] = $list ['id'];
    	$data ['titleLang1'] = $list ['title_lang1'];
    	$data ['titleLang2'] = $list ['title_lang2'];
    	$data ['titleLang3'] = $list ['title_lang3'];
    	$data ['articleLang1'] = Enum_Img::getPathByKeyAndType ( $list ['article_lang1'] );
    	$data ['articleLang2'] = Enum_Img::getPathByKeyAndType ( $list ['article_lang2'] );
    	$data ['articleLang3'] = Enum_Img::getPathByKeyAndType ( $list ['article_lang3'] );
    	$data ['tagId'] = $list ['tagid'];
    	$data ['status'] = $list ['status'];
    	$data ['createtime'] = $list ['createtime'];
    	$data ['updatetime'] = $list ['updatetime'];
    	return $data;
    }
}