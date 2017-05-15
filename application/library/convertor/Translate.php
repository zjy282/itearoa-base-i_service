<?php
/**
 * 翻译结果转换器
 */
class Convertor_Translate extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 翻译结果转换器
	 * 
	 * @param array $list
	 *        	翻译结果
	 * @return array
	 */
	public function translateResultConvertor($list) {
		$data = array ();
		$data ['from'] = $list ['from'];
		$data ['to'] = $list ['to'];
		$data ['src'] = $list ['trans_result'] [0] ['src'];
		$data ['result'] = $list ['trans_result'] [0] ['dst'];
		return $data;
	}
}