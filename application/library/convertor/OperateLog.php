<?php
/**
 * 操作日志转换器类
 */
class Convertor_OperateLog extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 操作日志列表
	 * 
	 * @param array $list
	 *        	操作日志列表
	 * @param int $count
	 *        	操作日志总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getOperateLogListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$iserviceOperatorIdList = $hotelOperatorIdList = $groupOperatorIdList = array ();
		$hotelIdList = $groupIdList = array ();
		foreach ( $list as $key => $value ) {
			switch ($value ['admintype']) {
				case Enum_OperateLog::RECORD_ADMIN_TYPE_ID :
					$iserviceOperatorIdList [] = $value ['operatorId'];
					break;
				case Enum_OperateLog::RECORD_GROUP_TYPE_ID :
					$hotelOperatorIdList [] = $value ['operatorId'];
					$groupIdList [] = $value ['admintypeid'];
					break;
				case Enum_OperateLog::RECORD_HOTEL_TYPE_ID :
					$groupOperatorIdList [] = $value ['operatorId'];
					$hotelIdList [] = $value ['admintypeid'];
					break;
			}
		}
		if ($iserviceOperatorIdList) {
			$iserviceOperatorModel = new IserviceAdministratorModel ();
			$iserviceOperatorInfoList = $iserviceOperatorModel->getIserviceAdministratorList ( array ('id' => $iserviceOperatorIdList ) );
			$iserviceOperatorNameList = array_column ( $iserviceOperatorInfoList, 'realname', 'id' );
		}
		if ($hotelOperatorIdList) {
			$hotelOperatorModel = new HotelAdministratorModel ();
			$hotelOperatorInfoList = $hotelOperatorModel->getHotelAdministratorList ( array ('id' => $hotelOperatorIdList ) );
			$hotelOperatorNameList = array_column ( $hotelOperatorInfoList, 'realname', 'id' );
		}
		if ($groupOperatorIdList) {
			$groupOperatorModel = new AdministratorModel ();
			$groupOperatorInfoList = $groupOperatorModel->getAdministratorList ( array ('id' => $iserviceOperatorIdList ) );
			$groupOperatorNameList = array_column ( $groupOperatorInfoList, 'realname', 'id' );
		}
		if ($hotelIdList) {
			$hotelListModel = new HotelListModel ();
			$hotelInfoList = $hotelListModel->getHotelListList ( array ('id' => $hotelIdList ) );
			$hotelNameList = array_column ( $hotelInfoList, 'name_lang1', 'id' );
			$hotelGroupList = array_column ( $hotelInfoList, 'groupid', 'id' );
			$groupIdList = array_merge ( $groupIdList, $hotelGroupList );
		}
		if ($groupIdList) {
			$groupModel = new GroupModel ();
			$groupInfoList = $groupModel->getGroupList ( array ('id' => $groupIdList ) );
			$groupNameList = array_column ( $groupInfoList, 'name', 'id' );
		}
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['operatorId'] = $value ['operatorId'];
			$oneTemp ['dataid'] = $value ['dataid'];
			$oneTemp ['msg'] = $value ['msg'];
			$oneTemp ['module'] = $value ['module'];
			$oneTemp ['action'] = $value ['action'];
			$oneTemp ['addtime'] = $value ['addtime'];
			$oneTemp ['miscinfo'] = $value ['miscinfo'];
			$oneTemp ['ip'] = $value ['ip'];
			$oneTemp ['code'] = $value ['code'];
			$oneTemp ['admintype'] = $value ['admintype'];
			$oneTemp ['admintypeid'] = $value ['admintypeid'];
			switch ($oneTemp ['admintype']) {
				case Enum_OperateLog::RECORD_ADMIN_TYPE_ID :
					$oneTemp ['operatorName'] = $iserviceOperatorNameList [$oneTemp ['operatorId']];
					break;
				case Enum_OperateLog::RECORD_GROUP_TYPE_ID :
					$oneTemp ['operatorName'] = $hotelOperatorNameList [$oneTemp ['operatorId']];
					$oneTemp ['groupName'] = $groupNameList [$oneTemp ['admintypeid']];
					break;
				case Enum_OperateLog::RECORD_HOTEL_TYPE_ID :
					$oneTemp ['operatorName'] = $groupOperatorNameList [$oneTemp ['operatorId']];
					$oneTemp ['hotelName'] = $hotelNameList [$oneTemp ['admintypeid']];
					$oneTemp ['groupName'] = $groupNameList [$hotelGroupList [$oneTemp ['admintypeid']]];
					break;
			}
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}