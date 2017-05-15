<?php
/**
 * 酒店楼层信息转换器类
 *
 */
class FloorController extends \BaseController {

	/**
	 *
	 * @var FloorModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_Floor
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new FloorModel ();
		$this->convertor = new Convertor_Floor ();
	}

	/**
	 * 获取酒店楼层列表
	 *
	 * @return Json
	 */
	public function getFloorListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['id'] = intval ( $this->getParamList ( 'id' ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['floor'] = trim ( $this->getParamList ( 'floor' ) );
		$param ['status'] = $this->getParamList ( 'status' );
		if (is_null ( $param ['status'] )) {
			unset ( $param ['status'] );
		}
		$data = $this->model->getFloorList ( $param );
		$count = $this->model->getFloorCount ( $param );
		$data = $this->convertor->getFloorListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店楼层详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getFloorDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getFloorDetail ( $id );
			$data = $this->convertor->getFloorDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改酒店楼层信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateFloorByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['hotelid'] = $this->getParamList ( 'hotelid' );
			$param ['status'] = $this->getParamList ( 'status' );
			$param ['floor'] = $this->getParamList ( 'floor' );
			$param ['pic'] = $this->getParamList ( 'pic' );
			$param ['detail_lang1'] = $this->getParamList ( 'detail_lang1' );
			$param ['detail_lang2'] = $this->getParamList ( 'detail_lang2' );
			$param ['detail_lang3'] = $this->getParamList ( 'detail_lang3' );
			$data = $this->model->updateFloorById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加酒店楼层信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addFloorAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$param ['floor'] = trim ( $this->getParamList ( 'floor' ) );
		$param ['pic'] = trim ( $this->getParamList ( 'pic' ) );
		$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
		$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
		$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
		$data = $this->model->addFloor ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
