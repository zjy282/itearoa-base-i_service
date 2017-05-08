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
			$lifeTemp ['nameLang1'] = $poi ['name_lang1'];
			$lifeTemp ['nameLang2'] = $poi ['name_lang2'];
			$lifeTemp ['nameLang3'] = $poi ['name_lang3'];
			$lifeTemp ['addressLang1'] = $poi ['address_lang1'];
			$lifeTemp ['addressLang2'] = $poi ['address_lang2'];
			$lifeTemp ['addressLang3'] = $poi ['address_lang3'];
			$lifeTemp ['tel'] = $poi ['tel'];
			$lifeTemp ['hotelId'] = $poi ['hotelid'];
			$lifeTemp ['typeId'] = $poi ['typeid'];
			$lifeTemp ['introductLang1'] = $poi ['introduct_lang1'];
			$lifeTemp ['introductLang2'] = $poi ['introduct_lang2'];
			$lifeTemp ['introductLang3'] = $poi ['introduct_lang3'];
			$lifeTemp ['detailLang1'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang1'] );
			$lifeTemp ['detailLang2'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang2'] );
			$lifeTemp ['detailLang3'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang3'] );
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
		$data ['nameLang1'] = $poi ['name_lang1'];
		$data ['nameLang2'] = $poi ['name_lang2'];
		$data ['nameLang3'] = $poi ['name_lang3'];
		$data ['addressLang1'] = $poi ['address_lang1'];
		$data ['addressLang2'] = $poi ['address_lang2'];
		$data ['addressLang3'] = $poi ['address_lang3'];
		$data ['tel'] = $poi ['tel'];
		$data ['hotelId'] = $poi ['hotelid'];
		$data ['typeId'] = $poi ['typeid'];
		$data ['introductLang1'] = $poi ['introduct_lang1'];
		$data ['introductLang2'] = $poi ['introduct_lang2'];
		$data ['introductLang3'] = $poi ['introduct_lang3'];
		$data ['detailLang1'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang1'] );
		$data ['detailLang2'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang2'] );
		$data ['detailLang3'] = Enum_Img::getPathByKeyAndType ( $poi ['detail_lang3'] );
		$data ['lng'] = $poi ['lng'];
		$data ['createTime'] = $poi ['createtime'];
		$data ['updateTime'] = $poi ['updatetime'];
		$data ['status'] = $poi ['status'];
		return $data;
	}
}