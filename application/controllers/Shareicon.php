<?php
/**
 * 酒店分享图标控制器类
 *
 */
class ShareIconController extends \BaseController {

	/**
	 *
	 * @var ShareIconModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_ShareIcon
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new ShareIconModel ();
		$this->convertor = new Convertor_ShareIcon ();
	}

	/**
	 * 获取酒店分享图标列表
	 *
	 * @return Json
	 */
	public function getShareIconListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$data = $this->model->getShareIconList ( $param );
		$count = $this->model->getShareIconCount ( $param );
		$data = $this->convertor->getShareIconListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店分享图标详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getShareIconDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getShareIconDetail ( $id );
			$data = $this->convertor->getShareIconDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改酒店分享图标信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateShareIconByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['name'] = trim ( $this->getParamList ( 'name' ) );
			$data = $this->model->updateShareIconById ( $param, $id );
			$data = $this->convertor->commonConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 添加酒店分享图标信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addShareIconAction() {
		$param = array ();
		$param ['name'] = trim ( $this->getParamList ( 'name' ) );
		$data = $this->model->addShareIcon ( $param );
		$data = $this->convertor->commonConvertor ( $data );
		$this->echoJson ( $data );
	}

	/**
	 * 根据hotelId修改酒店分享图标信息
	 *
	 * @param
	 *        	int hotelId 物业的id
	 * @param
	 *        	array param 分享平台信息
	 * @return Json
	 */
	public function updateShareByHotelIdAction() {
		$hotelId = intval ( $this->getParamList ( 'hotelid' ) );
		if ($hotelId) {
			$param = array ();
			$param ['share'] = trim ( $this->getParamList ( 'share' ) );
			$data = $this->model->updateShareByHotelId ( $param, $hotelId );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, '物业id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}
}
