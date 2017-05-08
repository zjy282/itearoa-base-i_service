<?php
/**
 * 本地攻略convertor
 * @author ZXM
 */
class Convertor_Poi extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	public function getPoiListConvertor($poiList, $poiCount, $param) {
		$data = array ('list' => array () );
		foreach ( $poiList as $pois ) {
			$poiTemp = array ();
			$poiTemp ['id'] = $pois ['id'];
			$poiTemp ['name'] = $this->handlerMultiLang ( 'name', $pois );
			$poiTemp ['address'] = $this->handlerMultiLang ( 'address', $pois );
			$poiTemp ['tel'] = $pois ['tel'];
			$poiTemp ['introduct'] = $this->handlerMultiLang ( 'introduct', $pois );
			$poiTemp ['detail'] = Enum_Img::getPathByKeyAndType ( $this->handlerMultiLang ( 'detail', $pois ) );
			$poiTemp ['lat'] = $pois ['lat'];
			$poiTemp ['lng'] = $pois ['lng'];
			$data ['list'] [] = $poiTemp;
		}
		$data ['total'] = $poiCount;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	public function getAdminPoiListConvertor($poiList, $poiCount, $param) {
		$data = array ('list' => array () );
		foreach ( $poiList as $poi ) {
			$lifeTemp = array ();
			$lifeTemp ['id'] = $poi ['id'];
			$lifeTemp ['name_lang1'] = $poi ['name_lang1'];
			$lifeTemp ['name_lang2'] = $poi ['name_lang2'];
			$lifeTemp ['name_lang3'] = $poi ['name_lang3'];
			$lifeTemp ['address_lang1'] = $poi ['address_lang1'];
			$lifeTemp ['address_lang2'] = $poi ['address_lang2'];
			$lifeTemp ['address_lang3'] = $poi ['address_lang3'];
			$lifeTemp ['tel'] = $poi ['tel'];
			$lifeTemp ['hotelId'] = $poi ['hotelid'];
			$lifeTemp ['typeId'] = $poi ['typeid'];
			$lifeTemp ['introduct_lang1'] = $poi ['introduct_lang1'];
			$lifeTemp ['introduct_lang2'] = $poi ['introduct_lang2'];
			$lifeTemp ['introduct_lang3'] = $poi ['introduct_lang3'];
			$lifeTemp ['detail_lang1'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang1'] );
			$lifeTemp ['detail_lang2'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang2'] );
			$lifeTemp ['detail_lang3'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang3'] );
			$lifeTemp ['lat'] = $poi ['lat'];
			$lifeTemp ['lng'] = $poi ['lng'];
			$data ['list'] [] = $lifeTemp;
		}
		$data ['total'] = $poiCount;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}

	public function getPoiDetailConvertor($poi) {
		$data = array ();
		$data ['id'] = $poi ['id'];
		$data ['name'] = $this->handlerMultiLang ( 'name', $poi );
		$data ['address'] = $this->handlerMultiLang ( 'address', $poi );
		$data ['tel'] = $poi ['tel'];
		$data ['hotelId'] = $poi ['hotelid'];
		$data ['typeId'] = $poi ['typeid'];
		$data ['introduct'] = $this->handlerMultiLang ( 'introduct', $poi );
		$data ['detail'] = Enum_Img::getPathByKeyAndType ( $this->handlerMultiLang ( 'detail', $poi ) );
		$data ['lat'] = $poi ['lat'];
		$data ['lng'] = $poi ['lng'];
		$data ['createTime'] = $poi ['createtime'];
		$data ['updateTime'] = $poi ['updatetime'];
		$data ['status'] = $poi ['status'];
		return $data;
	}

	public function getAdminPoiDetailConvertor($poi) {
		$data = array ();
		$data ['id'] = $poi ['id'];
		$data ['name_lang1'] = $poi ['name_lang1'];
		$data ['name_lang2'] = $poi ['name_lang2'];
		$data ['name_lang3'] = $poi ['name_lang3'];
		$data ['address_lang1'] = $poi ['address_lang1'];
		$data ['address_lang2'] = $poi ['address_lang2'];
		$data ['address_lang3'] = $poi ['address_lang3'];
		$data ['tel'] = $poi ['tel'];
		$data ['hotelId'] = $poi ['hotelid'];
		$data ['typeId'] = $poi ['typeid'];
		$data ['introduct_lang1'] = $poi ['introduct_lang1'];
		$data ['introduct_lang2'] = $poi ['introduct_lang2'];
		$data ['introduct_lang3'] = $poi ['introduct_lang3'];
		$data ['detail_lang1'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang1'] );
		$data ['detail_lang2'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang2'] );
		$data ['detail_lang3'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang3'] );
		$data ['lng'] = $poi ['lng'];
		$data ['lat'] = $poi ['lat'];
		$data ['createTime'] = $poi ['createtime'];
		$data ['updateTime'] = $poi ['updatetime'];
		$data ['status'] = $poi ['status'];
		return $data;
	}
}