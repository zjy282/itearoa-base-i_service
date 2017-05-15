<?php
/**
 * 酒店本地攻略控制器类
 *
 */
class PoiController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new PoiModel ();
		$this->convertor = new Convertor_Poi ();
	}

	/**
	 * 获取酒店本地攻略列表
	 *
	 * @return Json
	 */
	public function getPoiListAction() {
		$param = array ();
		$param ['typeid'] = intval ( $this->getParamList ( 'typeid' ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['id'] = intval ( $this->getParamList ( 'id' ) );
		$param ['name'] = $this->getParamList ( 'name' );
		$param ['status'] = $this->getParamList ( 'status' );
		$this->getPageParam ( $param );
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '入参错误' );
		}
		$poiList = $this->model->getPoiList ( $param );
		$poiCount = $this->model->getPoiCount ( $param );
		if ($this->package != Enum_System::ADMIN_PACKAGE) {
			$data = $this->convertor->getPoiListConvertor ( $poiList, $poiCount, $param );
		} else {
			$poiTypeModel = new PoiTypeModel ();
			$typeParam ['hotelid'] = $param ['hotelid'];
			$typeList = $poiTypeModel->getPoiTypeList ( $typeParam );
			$data = $this->convertor->getAdminPoiListConvertor ( $poiList, $poiCount, $param, $typeList );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店本地攻略详情
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
			$this->package != Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getPoiDetailConvertor ( $data ) : $data = $this->convertor->getAdminPoiDetailConvertor ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改酒店本地攻略信息
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
			$param ['hotelid'] = $this->getParamList ( 'hotelid' );
			$param ['typeid'] = $this->getParamList ( 'typeid' );
			$param ['name_lang1'] = $this->getParamList ( 'name_lang1' );
			$param ['name_lang2'] = $this->getParamList ( 'name_lang2' );
			$param ['name_lang3'] = $this->getParamList ( 'name_lang3' );
			$param ['detail_lang1'] = $this->getParamList ( 'detail_lang1' );
			$param ['detail_lang2'] = $this->getParamList ( 'detail_lang2' );
			$param ['detail_lang3'] = $this->getParamList ( 'detail_lang3' );
			$param ['address_lang1'] = $this->getParamList ( 'address_lang1' );
			$param ['address_lang2'] = $this->getParamList ( 'address_lang2' );
			$param ['address_lang3'] = $this->getParamList ( 'address_lang3' );
			$param ['introduct_lang1'] = $this->getParamList ( 'introduct_lang1' );
			$param ['introduct_lang2'] = $this->getParamList ( 'introduct_lang2' );
			$param ['introduct_lang3'] = $this->getParamList ( 'introduct_lang3' );
			$param ['tel'] = $this->getParamList ( 'tel' );
			$param ['lat'] = $this->getParamList ( 'lat' );
			$param ['lng'] = $this->getParamList ( 'lng' );
			$param ['updatetime'] = time ();
			$param ['status'] = $this->getParamList ( 'status' );
			$data = $this->model->updatePoiById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加酒店本地攻略信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addPoiAction() {
		$param = array ();
		$param ['hotelid'] = $this->getParamList ( 'hotelid' );
		$param ['typeid'] = $this->getParamList ( 'typeid' );
		$param ['name_lang1'] = $this->getParamList ( 'name_lang1' );
		$param ['name_lang2'] = $this->getParamList ( 'name_lang2' );
		$param ['name_lang3'] = $this->getParamList ( 'name_lang3' );
		$param ['address_lang1'] = $this->getParamList ( 'address_lang1' );
		$param ['address_lang2'] = $this->getParamList ( 'address_lang2' );
		$param ['address_lang3'] = $this->getParamList ( 'address_lang3' );
		$param ['introduct_lang1'] = $this->getParamList ( 'introduct_lang1' );
		$param ['introduct_lang2'] = $this->getParamList ( 'introduct_lang2' );
		$param ['introduct_lang3'] = $this->getParamList ( 'introduct_lang3' );
		$param ['tel'] = $this->getParamList ( 'tel' );
		$param ['lat'] = $this->getParamList ( 'lat' );
		$param ['lng'] = $this->getParamList ( 'lng' );
		$param ['updatetime'] = time ();
		$param ['createtime'] = time ();
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$data = $this->model->addPoi ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
