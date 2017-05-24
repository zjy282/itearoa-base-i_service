<?php
/**
 * 酒店问卷调查转换器类
 *
 */
class Convertor_FeedbackList extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 酒店问卷调查列表
	 * 
	 * @param array $list
	 *        	酒店问卷调查列表
	 * @return array
	 */
	public function getFeedbackListConvertor($list) {
		$data = array ();
		$data ['list'] = array ();
		foreach ( $list as $question ) {
			$questionTemp = array ();
			$questionTemp ['id'] = $question ['id'];
			$questionTemp ['name'] = $question ['name'];
			$data ['list'] [] = $questionTemp;
		}
		return $data;
	}

	/**
	 * 后台酒店问卷调查列表
	 * @param array $list 酒店问卷调查列表
	 * @param int $count 酒店问卷调查列表总数
	 * @param array $param 扩展参数
	 * @return array
	 */
	public function getListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['name'] = $value ['name'];
			$oneTemp ['sort'] = $value ['sort'];
			$oneTemp ['status'] = $value ['status'];
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
