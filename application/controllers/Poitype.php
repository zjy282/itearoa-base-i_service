<?php
/**
 * 酒店本地攻略类别控制器类
 *
 */
class PoiTypeController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new PoiTypeModel ();
		$this->convertor = new Convertor_PoiType ();
	}

	/**
	 * 获取酒店本地攻略类别列表
	 *
	 * @return Json
	 */
	public function getPoiTypeListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		$data = $this->model->getPoiTypeList ( $param );
		$data = $this->convertor->getPoiTypeListConvertor ( $data );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 获取酒店本地攻略类别列表
	 *
	 * @return Json
	 */
	public function getAdminPoiTypeListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$limit = $this->getParamList ( 'limit' );
		$param ['limit'] = isset ( $limit ) ? $limit : null;
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		$data = $this->model->getPoiTypeList ( $param );
		$count = $this->model->getPoiTypeCount ( $param );
		$data = $this->convertor->getAdminPoiTypeListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店本地攻略类别详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getPoiTypeDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getPoiTypeDetail ( $id );
			$data = $this->convertor->getPoiTypeDetailConvertor ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改酒店本地攻略类别信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updatePoiTypeByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
			$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
			$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
			$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
			$data = $this->model->updatePoiTypeById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加酒店本地攻略类别信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addPoiTypeAction() {
		$param = array ();
		$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
		$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
		$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
		$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
		$data = $this->model->addPoiType ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
