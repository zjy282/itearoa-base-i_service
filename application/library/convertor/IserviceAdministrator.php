<?php
/**
 * 总后台管理员转换器类
 *
 */
class Convertor_IserviceAdministrator extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 总后台管理员列表数据转换器
	 *
	 * @param array $list
	 *        	总后台管理员列表
	 * @param int $count
	 *        	总后台管理员数据总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getIserviceAdministratorListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['userName'] = $value ['username'];
			$oneTemp ['realName'] = $value ['realname'];
			$oneTemp ['status'] = $value ['status'];
			$oneTemp ['remark'] = $value ['remark'];
			$oneTemp ['lastLoginTime'] = $value ['lastlogintime'];
			$oneTemp ['lastLoginIp'] = $value ['lastloginip'];
			$oneTemp ['createTime'] = $value ['createtime'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	/**
	 * 总后台管理员详情数据转换器
	 *
	 * @param array $result
	 *        	总后台管理员详情数据
	 * @return array
	 */
	public function getIserviceAdministratorDetailConvertor($result) {
		$data = array ();
		if (is_array ( $result ) && count ( $result ) > 0) {
			$data ['id'] = $result ['id'];
			$data ['userName'] = $result ['username'];
			$data ['realName'] = $result ['realname'];
			// $data ['password'] = $result['password'];
			$data ['status'] = $result ['status'];
			$data ['remark'] = $result ['remark'];
			$data ['lastLoginTime'] = $result ['lastlogintime'];
			$data ['lastLoginIp'] = $result ['lastloginip'];
			$data ['createTime'] = $result ['createtime'];
			$data ['createAdmin'] = $result ['createadmin'];
		}
		return $data;
	}
}
