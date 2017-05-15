<?php
/**
 * 酒店APP标题转换器类
 *
 */
class Convertor_AppTitle extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 后台酒店APP标题列表
	 *
	 * @param array $list
	 *        	酒店APP标题列表
	 * @param int $count
	 *        	酒店APP标题列表总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getAppTitleListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['key'] = $value ['key'];
			$oneTemp ['title_lang1'] = $value ['title_lang1'];
			$oneTemp ['title_lang2'] = $value ['title_lang2'];
			$oneTemp ['title_lang3'] = $value ['title_lang3'];
			$oneTemp ['hotelid'] = $value ['hotelid'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	/**
	 * 酒店APP标题列表
	 *
	 * @param array $list
	 *        	酒店APP标题列表
	 * @return array
	 */
	public function hotelAppTitleListConvertor($list) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['title'] = $this->handlerMultiLang ( 'title', $value );
			$data ['list'] [$value ['key']] = $oneTemp;
		}
		return $data;
	}
}
