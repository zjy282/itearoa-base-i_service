<?php
/**
 * 物业图片转换器类
 *
 */
class Convertor_HotelPic extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 物业图片列表结果转换器
	 * 
	 * @param array $list
	 *        	物业图片列表
	 * @param int $count
	 *        	物业图片总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getHotelPicListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['pic'] = $value ['pic'];
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
