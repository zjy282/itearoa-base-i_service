<?php
/**
 * APP问题反馈转换器类
 *
 */
class Convertor_IserviceFeedback extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * APP问题反馈列表
	 * 
	 * @param array $list
	 *        	APP问题反馈列表
	 * @param int $count
	 *        	APP问题反馈总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getIserviceFeedbackListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['createtime'] = $value ['createtime'];
			$oneTemp ['email'] = $value ['email'];
			$oneTemp ['content'] = $value ['content'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}
