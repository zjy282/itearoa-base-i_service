<?php
/**
 * 预约看房订单转换器
 */
class Convertor_ShowingOrder extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 可用的预约看房订单
	 *
	 * @param array $list
	 *        	可用的预约看房订单
	 * @param int $count
	 *        	可用的预约看房订单总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getShowingOrderListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$statusNameList = Enum_ShowingOrder::getStatusNameList ();
		foreach ( $list as $listOne ) {
			$listOneTemp = array ();
			$listOneTemp ['id'] = $listOne ['id'];
			$listOneTemp ['contact_name'] = $listOne ['contact_name'];
			$listOneTemp ['contact_mobile'] = $listOne ['contact_mobile'];
			$listOneTemp ['userid'] = $listOne ['userid'];
			$listOneTemp ['hotelid'] = $listOne ['hotelid'];
			$listOneTemp ['status'] = $listOne ['status'];
			$listOneTemp ['createtime'] = $listOne ['createtime'];
			$listOneTemp ['statusName'] = $statusNameList [$listOne ['status']];
			$listOneTemp ['adminid'] = $listOne ['adminid'];
			$data ['list'] [] = $listOneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	/**
	 * 后台预约看房订单详情
	 *
	 * @param array $list
	 *        	预约看房订单详情
	 * @param int $count
	 *        	预约看房订单总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getOrderListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$adminIdList = array_column ( $list, 'adminid' );
		if ($adminIdList) {
			$staffModel = new StaffModel ();
			$adminInfoList = $staffModel->getStaffList ( array ('id' => $adminIdList ) );
			$adminNameList = array_column ( $adminInfoList, 'lname', 'id' );
		}
		$statusNameList = Enum_ShowingOrder::getStatusNameList ();
		foreach ( $list as $listOne ) {
			$listOneTemp = array ();
			$listOneTemp ['id'] = $listOne ['id'];
			$listOneTemp ['userid'] = $listOne ['userid'];
			$listOneTemp ['contact_name'] = $listOne ['contact_name'];
			$listOneTemp ['contact_mobile'] = $listOne ['contact_mobile'];
			$listOneTemp ['createtime'] = $listOne ['createtime'];
			$listOneTemp ['status'] = $listOne ['status'];
			$listOneTemp ['statusName'] = $statusNameList [$listOne ['status']];
			$listOneTemp ['adminid'] = $listOne ['adminid'];
			$listOneTemp ['adminName'] = $adminNameList [$listOne ['adminid']];
			$data ['list'] [] = $listOneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}