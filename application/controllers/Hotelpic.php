<?php
/**
 * 物业图片控制器类
 *
 */
class HotelPicController extends \BaseController {

	/**
	 *
	 * @var HotelPicModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_HotelPic
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new HotelPicModel ();
		$this->convertor = new Convertor_HotelPic ();
	}

	/**
	 * 获取物业图片列表
	 *
	 * @return Json
	 */
	public function getHotelPicListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$data = $this->model->getHotelPicList ( $param );
		$count = $this->model->getHotelPicCount ( $param );
		$data = $this->convertor->getHotelPicListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取物业图片详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getHotelPicDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getHotelPicDetail ( $id );
			$data = $this->convertor->getHotelPicDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改物业图片信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateHotelPicByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['hotelid'] = $this->getParamList ( 'hotelid' );
			$param ['sort'] = $this->getParamList ( 'sort' );
			$param ['pic'] = $this->getParamList ( 'pic' );
			$data = $this->model->updateHotelPicById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加物业图片信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addHotelPicAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['pic'] = trim ( $this->getParamList ( 'pic' ) );
		$param ['sort'] = intval ( $this->getParamList ( 'sort' ) );
		$data = $this->model->addHotelPic ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
