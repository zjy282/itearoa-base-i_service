<?php
/**
 * 电话黄页转换器
 */
class Convertor_Tel extends Convertor_Base {

	public function __construct() {
		parent::__construct ();
	}

	/**
	 * 电话黄页列表
	 *
	 * @param array $telTypeList
	 *        	电话黄页类型
	 * @param array $telList
	 *        	电话黄页列表
	 * @return array
	 */
	public function hotelTelListConvertor($telTypeList, $telList) {
		$data = array ('list' => array () );
		$telListByType = array ();
		foreach ( $telList as $tel ) {
			$telListByType [$tel ['typeid']] [] = array ('id' => $tel ['id'],'title' => $this->handlerMultiLang ( 'title', $tel ),'tel' => $tel ['tel'] );
		}
		foreach ( $telTypeList as $type ) {
			$typeTemp = array ();
			$typeTemp ['id'] = $type ['id'];
			$typeTemp ['title'] = $this->handlerMultiLang ( 'title', $type );
			$typeTemp ['telList'] = $telListByType [$type ['id']] ? $telListByType [$type ['id']] : array ();
			$data ['list'] [] = $typeTemp;
		}
		return $data;
	}

	/**
	 * 后台电话黄页列表
	 *
	 * @param array $telTypeList
	 *        	电话黄页类型
	 * @param array $telList
	 *        	电话黄页列表
	 * @return array
	 */
	public function getTelListConvertor($list, $count, $param) {
		$data = array ('list' => array () );
		$typeIdList = array_unique ( array_column ( $list, 'typeid' ) );
		$telTypeModel = new TelTypeModel ();
		$typeInfoList = $telTypeModel->getTelTypeList ( array ('id' => $typeIdList ) );
		$typeNameList = array_column ( $typeInfoList, 'title_lang1', 'id' );
		foreach ( $list as $key => $value ) {
			$oneTemp = array ();
			$oneTemp ['id'] = $value ['id'];
			$oneTemp ['title_lang1'] = $value ['title_lang1'];
			$oneTemp ['title_lang2'] = $value ['title_lang2'];
			$oneTemp ['title_lang3'] = $value ['title_lang3'];
			$oneTemp ['tel'] = $value ['tel'];
			$oneTemp ['status'] = $value ['status'];
			$oneTemp ['typeid'] = $value ['typeid'];
			$oneTemp ['typeName'] = $typeNameList [$value ['typeid']];
			$oneTemp ['hotelid'] = $value ['hotelid'];
			$data ['list'] [] = $oneTemp;
		}
		$data ['total'] = $count;
		$data ['page'] = $param ['page'];
		$data ['limit'] = $param ['limit'];
		$data ['nextPage'] = Util_Tools::getNextPage ( $data ['page'], $data ['limit'], $data ['total'] );
		return $data;
	}
}