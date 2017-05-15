<?php
/**
 * 雅士阁生活类别控制器类
 *
 */
class LifeTypeController extends \BaseController {

	/**
	 *
	 * @var LifeTypeModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_LifeType
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new LifeTypeModel ();
		$this->convertor = new Convertor_LifeType ();
	}

	/**
	 * 获取雅士阁生活类别列表
	 *
	 * @return Json
	 */
	public function getLifeTypeListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		$data = $this->model->getLifeTypeList ( $param );
		$data = $this->convertor->getLifeTypeListConvertor ( $data );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 获取后台雅士阁生活类别列表
	 *
	 * @return Json
	 */
	public function getAdminLifeTypeListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$limit = $this->getParamList ( 'limit' );
		$param ['limit'] = isset ( $limit ) ? $limit : null;
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		$data = $this->model->getLifeTypeList ( $param );
		$count = $this->model->getLifeTypeCount ( $param );
		$data = $this->convertor->getAdminLifeTypeListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取雅士阁生活类别详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getLifeTypeDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getLifeTypeDetail ( $id );
			$data = $this->convertor->getLifeTypeDetailConvertor ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改雅士阁生活类别信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateLifeTypeByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
			$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
			$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
			$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
			$data = $this->model->updateLifeTypeById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加雅士阁生活类别信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addLifeTypeAction() {
		$param = array ();
		$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
		$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
		$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
		$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
		$data = $this->model->addLifeType ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
