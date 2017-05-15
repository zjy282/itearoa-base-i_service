<?php
/**
 * 用户入住历史结果转换器
 */
class Convertor_UserHistory extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 用户入住历史转换器
	 * 
	 * @param array $list        	
	 * @return array
	 */
	public function userHistoryListConvertor($list) {
		$data = array ('list' => array () );
		foreach ( $list as $history ) {
			$historyTemp = array ();
			$historyTemp ['id'] = $history ['id'];
			$historyTemp ['userid'] = $history ['userid'];
			$historyTemp ['hotelid'] = $history ['hotelid'];
			$historyTemp ['groupid'] = $history ['groupid'];
			$historyTemp ['checkin'] = $history ['checkin'];
			$historyTemp ['checkout'] = $history ['checkout'];
			$data ['list'] [] = $historyTemp;
		}
		return $data;
	}
}