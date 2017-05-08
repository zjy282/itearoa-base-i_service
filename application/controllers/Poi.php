<?php
class PoiController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new PoiModel ();
		$this->convertor = new Convertor_Poi ();
	}

	/**
	 * 获取Poi列表
	 *
	 * @return Json
	 */
	public function getPoiListAction() {
		$param = array ();
		$param ['typeid'] = intval ( $this->getParamList ( 'typeid' ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$this->getPageParam ( $param );
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '入参错误' );
		}
		$poiList = $this->model->getPoiList ( $param );
		$poiCount = $this->model->getPoiCount ( $param );
		$this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getPoiListConvertor ( $poiList, $poiCount, $param ) : $data = $this->convertor->getAdminPoiListConvertor ( $poiList, $poiCount, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取Poi详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getPoiDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getPoiDetail ( $id );
			$data = $this->convertor->getPoiDetailConvertor ( $data );
			$this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getPoiDetailConvertor ( $data) : $data = $this->convertor->getAdminPoiDetailConvertor ( $poi );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改Poi信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updatePoiByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
			$param ['typeid'] = trim ( $this->getParamList ( 'typeid' ) );
			$param ['name_lang1'] = trim ( $this->getParamList ( 'name_lang1' ) );
			$param ['name_lang2'] = trim ( $this->getParamList ( 'name_lang2' ) );
			$param ['name_lang3'] = trim ( $this->getParamList ( 'name_lang3' ) );
			$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
			$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
			$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
			$param ['address_lang1'] = trim ( $this->getParamList ( 'address_lang1' ) );
			$param ['address_lang2'] = trim ( $this->getParamList ( 'address_lang2' ) );
			$param ['address_lang3'] = trim ( $this->getParamList ( 'address_lang3' ) );
			$param ['introduct_lang1'] = trim ( $this->getParamList ( 'introduct_lang1' ) );
			$param ['introduct_lang2'] = trim ( $this->getParamList ( 'introduct_lang2' ) );
			$param ['introduct_lang3'] = trim ( $this->getParamList ( 'introduct_lang3' ) );
			$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
			$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
			$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
			$param ['tel'] = trim ( $this->getParamList ( 'tel' ) );
			$param ['lat'] = trim ( $this->getParamList ( 'lat' ) );
			$param ['lng'] = trim ( $this->getParamList ( 'lng' ) );
			$param ['updatetime'] = time ();
			$param ['status'] = intval ( $this->getParamList ( 'status' ) );
			$data = $this->model->updatePoiById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加Poi信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addPoiAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['typeid'] = intval ( $this->getParamList ( 'typeid' ) );
		$param ['name_lang1'] = trim ( $this->getParamList ( 'name_lang1' ) );
		$param ['name_lang2'] = trim ( $this->getParamList ( 'name_lang2' ) );
		$param ['name_lang3'] = trim ( $this->getParamList ( 'name_lang3' ) );
		$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
		$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
		$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
		$param ['address_lang1'] = trim ( $this->getParamList ( 'address_lang1' ) );
		$param ['address_lang2'] = trim ( $this->getParamList ( 'address_lang2' ) );
		$param ['address_lang3'] = trim ( $this->getParamList ( 'address_lang3' ) );
		$param ['introduct_lang1'] = trim ( $this->getParamList ( 'introduct_lang1' ) );
		$param ['introduct_lang2'] = trim ( $this->getParamList ( 'introduct_lang2' ) );
		$param ['introduct_lang3'] = trim ( $this->getParamList ( 'introduct_lang3' ) );
		$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
		$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
		$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
		$param ['tel'] = trim ( $this->getParamList ( 'tel' ) );
		$param ['lat'] = trim ( $this->getParamList ( 'lat' ) );
		$param ['lng'] = trim ( $this->getParamList ( 'lng' ) );
		$param ['updatetime'] = time ();
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$data = $this->model->addPoi ( $param );
		$data = $this->convertor->statusConvertor ( $data );
		$this->echoSuccessData ( $data );
	}
}
