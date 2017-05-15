<?php
/**
 * 体验购物标签转换器
 */
class Convertor_ShoppingTag extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 体验购物标签数据转换器
	 * 
	 * @param array $list
	 *        	体验购物标签
	 * @param int $count
	 *        	体验购物标签总数
	 * @param array $param
	 *        	扩展参数
	 * @return array
	 */
	public function getShoppingTagListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$hotelIdList = array_column ( $list, 'hotelid' );
		$hotelModel = new HotelListModel ();
		$hotelInfoList = $hotelModel->getHotelListList ( array ('id' => $hotelIdList ) );
		$hotelNameList = array_column ( $hotelInfoList, 'name_lang1', 'id' );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['title_lang1'] = $value ['title_lang1'];
			$oneTemp ['title_lang2'] = $value ['title_lang2'];
			$oneTemp ['title_lang3'] = $value ['title_lang3'];
			$oneTemp ['hotelId'] = $value ['hotelid'];
			$oneTemp ['hotelName'] = $hotelNameList [$value ['hotelid']];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}
