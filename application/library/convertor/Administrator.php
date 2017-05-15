<?php
/**
 * 集团管理员结果转换器类
 */
class Convertor_Administrator extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 集团管理员列表数据转换器
	 *
	 * @param array $list
	 *        	集团管理员标签列表数据
	 * @param int $count
	 *        	集团管理员标签列表数据总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getAdministratorListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$groupIdList = array_column ( $list, 'groupid' );
		$groupModel = new GroupModel ();
		$groupInfoList = $groupModel->getGroupList ( array ('id' => $groupIdList ) );
		$groupNameList = array_column ( $groupInfoList, 'name', 'id' );
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
			$oneTemp ['createAdmin'] = $value ['createAdmin'];
			$oneTemp ['groupId'] = $value ['groupid'];
			$oneTemp ['groupName'] = $groupNameList [$value ['groupid']];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	/**
	 * 集团管理员详情数据转换器
	 *
	 * @param array $result
	 *        	集团管理员详情数据
	 * @return array
	 */
	public function getAdministratorDetailConvertor($result) {
		$data = array ();
		if (is_array ( $result ) && count ( $result ) > 0) {
			$data ['id'] = $result ['id'];
			$data ['userName'] = $result ['username'];
			$data ['realName'] = $result ['realname'];
			$data ['remark'] = $result ['remark'];
			$data ['status'] = $result ['status'];
			$data ['lastLoginTime'] = $result ['lastlogintime'];
			$data ['lastLoginIp'] = $result ['lastloginip'];
			$data ['createTime'] = $result ['createtime'];
			$data ['createAdmin'] = $result ['createadmin'];
			$data ['groupId'] = $result ['groupid'];
		}
		return $data;
	}
} 
