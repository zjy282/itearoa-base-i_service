<?php
/**
 * 本地攻略标签转换器类
 */
class Convertor_PoiTag extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 酒店本地攻略标签列表
	 * 
	 * @param array $list        	
	 * @return array
	 */
	public function getPoiTagListConvertor($list) {
		$data = array ();
		$data ['list'] = array ();
		foreach ( $list as $type ) {
			$typeTemp = array ();
			$typeTemp ['id'] = $type ['id'];
			$typeTemp ['title'] = $this->handlerMultiLang ( 'title', $type );
			$data ['list'] [] = $typeTemp;
		}
		return $data;
	}

	/**
	 * 管理端酒店本地攻略标签转换器
	 * 
	 * @param array $list
	 *        	POI标签
	 * @param int $count
	 *        	POI标签总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getAdminPoiTagListConvertor($list, $count, $param) {
		$data = array ();
		$data ['list'] = array ();
		foreach ( $list as $type ) {
			$typeTemp = array ();
			$typeTemp ['id'] = $type ['id'];
			$typeTemp ['title_lang1'] = $type ['title_lang1'];
			$typeTemp ['title_lang2'] = $type ['title_lang2'];
			$typeTemp ['title_lang3'] = $type ['title_lang3'];
			$data ['list'] [] = $typeTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	/**
	 * 酒店本地攻略标签详情
	 * @param array $detail
	 * @return multitype:unknown string
	 */
	public function getPoiTagDetailConvertor($detail) {
		$data = array ();
		$data ['id'] = $detail ['id'];
		$data ['title'] = $this->handlerMultiLang ( 'title', $detail );
		return $data;
	}
}
