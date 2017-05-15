<?php
/**
 * 酒店快捷图标转换器
 *
 */
class Convertor_ShortcutIcon extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 酒店快捷图标列表
	 * 
	 * @param array $list
	 *        	酒店快捷图标
	 * @param int $count
	 *        	酒店快捷图标总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getShortcutIconListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['key'] = $value ['key'];
			$oneTemp ['title_lang1'] = $value ['title_lang1'];
			$oneTemp ['title_lang2'] = $value ['title_lang2'];
			$oneTemp ['title_lang3'] = $value ['title_lang3'];
			$oneTemp ['sort'] = $value ['sort'];
			$oneTemp ['hotelid'] = $value ['hotelid'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}
