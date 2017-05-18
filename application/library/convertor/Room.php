<?php
/**
 * 客房结果转换器
 */
class Convertor_Room extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 客房列表
	 * 
	 * @param array $list
	 *        	客房列表
	 * @param int $count
	 *        	客房总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getRoomListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['floor'] = $value ['floor'];
			$oneTemp ['typeId'] = $value ['typeid'];
			$oneTemp ['hotelId'] = $value ['hotelid'];
			$oneTemp ['size'] = $value ['size'];
			$oneTemp ['room'] = $value ['room'];
			$oneTemp ['createTime'] = $value ['createtime'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}
