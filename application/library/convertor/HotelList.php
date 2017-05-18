<?php
/**
 * 物业列表转换器类
 */
class Convertor_HotelList extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 物业列表数据转换器
	 * @param array $list 物业列表数据
	 * @param int $count 物业列表总数
	 * @param array $param 扩展参数
	 * @return array
	 */
	public function getHotelListListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$groupIdList = array_column ( $list, 'groupid' );
		$groupModel = new GroupModel ();
		$groupInfoList = $groupModel->getGroupList ( array ('id' => $groupIdList ) );
		$groupNameList = array_column ( $groupInfoList, 'name', 'id' );
		$cityIdList = array_column ( $list, 'cityid' );
		$cityModel = new CityModel ();
		$cityInfoList = $cityModel->getCityList ( array ('id' => $cityIdList ) );
		$cityNameList = array_column ( $cityInfoList, 'name', 'id' );
		$cityEnNameList = array_column ( $cityInfoList, 'enname', 'id' );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['groupid'] = $value ['groupid'];
			$oneTemp ['groupName'] = $groupNameList [$value ['groupid']];
			$oneTemp ['propertyinterfid'] = $value ['propertyinterfid'];
			$oneTemp ['lng'] = $value ['lng'];
			$oneTemp ['lat'] = $value ['lat'];
			$oneTemp ['cityid'] = $value ['cityid'];
			$oneTemp ['cityName'] = $cityNameList [$value ['cityid']];
			$oneTemp ['cityEnName'] = $cityEnNameList [$value ['cityid']];
			$oneTemp ['tel'] = $value ['tel'];
			$oneTemp ['name_lang1'] = $value ['name_lang1'];
			$oneTemp ['name_lang2'] = $value ['name_lang2'];
			$oneTemp ['name_lang3'] = $value ['name_lang3'];
			$oneTemp ['website'] = $value ['website'];
			$oneTemp ['logo'] = $value ['logo'];
			$oneTemp ['index_background'] = $value ['index_background'];
			$oneTemp ['voice_lang1'] = $value ['voice_lang1'];
			$oneTemp ['voice_lang2'] = $value ['voice_lang2'];
			$oneTemp ['voice_lang3'] = $value ['voice_lang3'];
			$oneTemp ['address_lang1'] = $value ['address_lang1'];
			$oneTemp ['address_lang2'] = $value ['address_lang2'];
			$oneTemp ['address_lang3'] = $value ['address_lang3'];
			$oneTemp ['introduction_lang1'] = $value ['introduction_lang1'];
			$oneTemp ['introduction_lang2'] = $value ['introduction_lang2'];
			$oneTemp ['introduction_lang3'] = $value ['introduction_lang3'];
			$oneTemp ['status'] = $value ['status'];
			$oneTemp ['lang_list'] = $value ['lang_list'];
			$oneTemp ['bookurl'] = $value ['bookurl'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	/**
	 * 当前可用的物业列表
	 * @param array $list 当前可用的物业列表
	 * @return array
	 */
	public function getEffectiveHotelListConvertor($list) {
		$data = array ('list' => array () );
		$cityIdList = array_column ( $list, 'cityid' );
		$cityModel = new CityModel ();
		$cityInfoList = $cityModel->getCityList ( array ('id' => $cityIdList ) );
		$cityInfoList = array_column ( $cityInfoList, null, 'id' );
		foreach ( $list as $hotel ) {
			$dataTemp = array ();
			$dataTemp ['hotelId'] = $hotel ['id'];
			$dataTemp ['propertyinterfId'] = $hotel ['propertyinterfid'];
			$dataTemp ['cityId'] = $hotel ['cityid'];
			$cityInfo = $cityInfoList [$dataTemp ['cityId']];
			$dataTemp ['cityName'] = $cityInfo ['name'];
			$dataTemp ['cityEnName'] = $cityInfo ['enname'];
			$dataTemp ['countryName'] = $cityInfo ['countryname'];
			$dataTemp ['countryEnName'] = $cityInfo ['countryenname'];
			$dataTemp ['name'] = $hotel ['name_lang1'];
			$dataTemp ['address'] = $hotel ['address'];
			$data ['list'] [] = $dataTemp;
		}
		return $data;
	}

	/**
	 * 根据id获取物业详情
	 * @param array $hotelInfo 物业详情
	 * @param array $hotelShareIcon 酒店分享信息
	 * @param array $hotelShortCutIcon 酒店快捷信息
	 * @return array
	 */
	public function getHotelListDetailConvertor($hotelInfo, $hotelShareIcon, $hotelShortCutIcon) {
		$cityModel = new CityModel ();
		$cityInfo = $cityModel->getCityDetail ( $hotelInfo ['cityid'] );
		$langNameList = Enum_Lang::getLangNameList ();
		$wetherModel = new WetherModel ();
		$wetherInfo = $wetherModel->getWeatherFromYahoo ( $cityInfo ['enname'] . ',' . $cityInfo ['countryenname'] );
		$data = array ();
		$data ['hotelId'] = $hotelInfo ['id'];
		$data ['groupId'] = $hotelInfo ['groupid'];
		$data ['propertyinterfId'] = $hotelInfo ['propertyinterfid'];
		$data ['lng'] = $hotelInfo ['lng'];
		$data ['lat'] = $hotelInfo ['lat'];
		$data ['cityId'] = $hotelInfo ['cityid'];
		$data ['cityName'] = $cityInfo ['name'];
		$data ['cityEnName'] = $cityInfo ['enname'];
		$data ['countryName'] = $cityInfo ['countryname'];
		$data ['countryEnName'] = $cityInfo ['countryenname'];
		$data ['tel'] = $hotelInfo ['tel'];
		$data ['name'] = $this->handlerMultiLang ( 'name', $hotelInfo );
		$data ['website'] = $hotelInfo ['website'];
		$data ['logo'] = Enum_Img::getPathByKeyAndType ( $hotelInfo ['logo'] );
		$data ['indexBackground'] = Enum_Img::getPathByKeyAndType ( $hotelInfo ['index_background'] );
		$data ['voice'] = Enum_Img::getPathByKeyAndType ( $this->handlerMultiLang ( 'voice', $hotelInfo ) );
		$data ['introduction'] = $this->handlerMultiLang ( 'introduction', $hotelInfo );
		$data ['address'] = $this->handlerMultiLang ( 'address', $hotelInfo );
		$langList = array_filter ( explode ( ',', $hotelInfo ['lang_list'] ) );
		$data ['wetherInfo'] = $wetherInfo;
		$data ['langList'] = array_intersect_key ( $langNameList, array_flip ( $langList ) );
		$data ['shareList'] = array ();
		foreach ( $hotelShareIcon as $share ) {
			$data ['shareList'] [] = array ('key' => $share ['key'] );
		}
		$data ['shortcutList'] = array ();
		foreach ( $hotelShortCutIcon as $shortCut ) {
			$data ['shortcutList'] [] = array ('key' => $shortCut ['key'],'title' => $this->handlerMultiLang ( 'title', $shortCut ) );
		}
		return $data;
	}

	/**
	 * 酒店详情
	 * @param array $hotel 酒店详情
	 * @return array
	 */
	public function hotelDetailConvertor($hotel) {
		$data = array ();
		$hotelInfo = $hotel ['hotelInfo'];
		$data ['id'] = $hotelInfo ['id'];
		$data ['groupid'] = $hotelInfo ['groupid'];
		$data ['propertyinterfid'] = $hotelInfo ['propertyinterfid'];
		$data ['lng'] = $hotelInfo ['lng'];
		$data ['lat'] = $hotelInfo ['lat'];
		$data ['tel'] = $hotelInfo ['tel'];
		$data ['name'] = $this->handlerMultiLang ( 'name', $hotelInfo );
		$data ['website'] = $hotelInfo ['website'];
		$data ['bookurl'] = $hotelInfo ['bookurl'];
		$data ['introduction'] = $this->handlerMultiLang ( 'introduction', $hotelInfo );
		$data ['pic'] = array ();
		foreach ( $hotel ['picList'] as $pic ) {
			$data ['pic'] [] = Enum_Img::getPathByKeyAndType ( $pic ['pic'] );
		}
		$data ['roomTypeList'] = array ();
		foreach ( $hotel ['roomTypeList'] as $roomType ) {
			$roomTypeTemp = array ();
			$roomTypeTemp ['title'] = $this->handlerMultiLang ( 'title', $roomType );
			$roomTypeTemp ['size'] = $roomType ['size'];
			$roomTypeTemp ['detail'] = $this->handlerMultiLang ( 'detail', $roomType );
			$roomTypeTemp ['panoramic'] = $roomType ['panoramic'];
			$roomTypeTemp ['bedtype'] = $this->handlerMultiLang ( 'bedtype', $roomType );
			$data ['roomTypeList'] [] = $roomTypeTemp;
		}
		$data ['facilitiesList'] = array ();
		foreach ( $hotel ['facilitiesList'] as $facilities ) {
			$facilitiesTemp = array ();
			$facilitiesTemp ['icon'] = $facilities['icon'];
			$facilitiesTemp ['name'] = $this->handlerMultiLang ( 'name', $facilities );
			$facilitiesTemp ['detail'] = $this->handlerMultiLang ( 'detail', $facilities );
			$facilitiesTemp ['introduct'] = $this->handlerMultiLang ( 'introduct', $facilities );
			$facilitiesTemp ['pdf'] = Enum_Img::getPathByKeyAndType ( $facilities['pdf'] );
			$facilitiesTemp ['video'] = Enum_Img::getPathByKeyAndType ( $facilities['video'] );
			$data ['facilitiesList'] [] = $facilitiesTemp;
		}
		$data ['floorList'] = array ();
		foreach ( $hotel ['floorList'] as $floor ) {
			$floorTemp = array ();
			$floorTemp ['floor'] = $floor ['floor'];
			$floorTemp ['detail'] = $this->handlerMultiLang ( 'detail', $floor );
			$floorTemp ['pic'] = Enum_Img::getPathByKeyAndType ( $floor ['pic'] );
			$data ['floorList'] [] = $floorTemp;
		}
		$data ['trafficList'] = array ();
		foreach ( $hotel ['trafficList'] as $traffic ) {
			$trafficTemp = array ();
			$trafficTemp ['introduct'] = $this->handlerMultiLang ( 'introduct', $traffic );
			$trafficTemp ['detail'] = $this->handlerMultiLang ( 'detail', $traffic );
            $trafficTemp ['pdf'] = Enum_Img::getPathByKeyAndType ( $traffic['pdf'] );
            $trafficTemp ['video'] = Enum_Img::getPathByKeyAndType ( $traffic['video'] );
			$data ['trafficList'] [] = $trafficTemp;
		}
		$data ['panoramicList'] = array ();
		foreach ( $hotel ['panoramicList'] as $panoramic ) {
			$panoramicTemp = array ();
			$panoramicTemp ['panoramic'] = $panoramic ['panoramic'];
			$panoramicTemp ['pic'] = Enum_Img::getPathByKeyAndType ( $panoramic ['pic'] );
			$panoramicTemp ['title'] = $this->handlerMultiLang ( 'title', $panoramic );
			$data ['panoramicList'] [] = $panoramicTemp;
		}
		return $data;
	}
}