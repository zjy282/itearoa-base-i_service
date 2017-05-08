<?php
/**
 * 新闻convertor
 * @author ZXM
 */
class Convertor_News extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	public function getNewsListConvertor($newsList, $tagList, $newsCount, $param) {
		$tagListNew = array ();
		foreach ( $tagList as $tag ) {
			$tagListNew [$tag ['id']] = $this->handlerMultiLang ( 'title', $tag );
		}
		$data = array ('list' => array () );
		foreach ( $newsList as $news ) {
			$newTemp = array ();
			$newTemp ['id'] = $news ['id'];
			$newTemp ['title'] = $this->handlerMultiLang ( 'title', $news );
			$newTemp ['article'] = Enum_Img::getPathByKeyAndType ( $this->handlerMultiLang ( 'article', $news ) );
			$newTemp ['tagId'] = $news ['tagid'];
			$newTemp ['tagName'] = $tagListNew [$newTemp ['tagId']];
			$newTemp ['createtime'] = $news ['createtime'];
			$newTemp ['updatetime'] = $news ['updatetime'];
			$data ['list'] [] = $newTemp;
		}
		$data ['total'] = $newsCount;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	public function getAdminNewsListConvertor($newsList, $tagList, $newsCount, $param) {
		$tagListNew = array ();
		foreach ( $tagList as $tag ) {
			$tagListNew [$tag ['id']] ['titleLang1'] = $tag ['title_lang1'];
			$tagListNew [$tag ['id']] ['titleLang2'] = $tag ['title_lang2'];
			$tagListNew [$tag ['id']] ['titleLang3'] = $tag ['title_lang3'];
		}
		$data = array ('list' => array () );
		foreach ( $newsList as $news ) {
			$newTemp = array ();
			$newTemp ['id'] = $news ['id'];
			$newTemp ['titleLang1'] = $news ['title_lang1'];
			$newTemp ['titleLang2'] = $news ['title_lang2'];
			$newTemp ['titleLang3'] = $news ['title_lang3'];
			$newTemp ['articleLang1'] = Enum_Img::getPathByKeyAndType ( $news ['article_lang1'] );
			$newTemp ['articleLang2'] = Enum_Img::getPathByKeyAndType ( $news ['article_lang2'] );
			$newTemp ['articleLang3'] = Enum_Img::getPathByKeyAndType ( $news ['article_lang3'] );
			$newTemp ['tagId'] = $news ['tagid'];
			$newTemp ['tagName_lang1'] = $tagListNew [$newTemp ['tagId']] ['title_lang1'];
			$newTemp ['tagName_lang2'] = $tagListNew [$newTemp ['tagId']] ['title_lang2'];
			$newTemp ['tagName_lang3'] = $tagListNew [$newTemp ['tagId']] ['title_lang3'];
			$newTemp ['createtime'] = $news ['createtime'];
			$newTemp ['updatetime'] = $news ['updatetime'];
			$data ['list'] [] = $newTemp;
		}
		$data ['total'] = $newsCount;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	public function getNewsDetailConvertor($list) {
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

	public function getAdminNewsDetailConvertor($list) {
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