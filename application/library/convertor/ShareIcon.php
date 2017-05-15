<?php
/**
 * 酒店分享图标转换器
 *
 */
class Convertor_ShareIcon extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 酒店分享图标列表
	 * @param array $list 酒店分享图标列表
	 * @param int $count 酒店分享图标总数
	 * @param array $param 扩展参数
	 * @return array
	 */
	public function getShareIconListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['key'] = $value ['key'];
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
