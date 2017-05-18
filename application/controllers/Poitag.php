<?php
/**
 * 酒店本地攻略标签控制器类
 *
 */
class PoiTagController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new PoiTagModel ();
		$this->convertor = new Convertor_PoiTag ();
	}

	/**
	 * 获取酒店本地攻略标签列表
	 *
	 * @return Json
	 */
	public function getPoiTagListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		$data = $this->model->getPoiTagList ( $param );
		$data = $this->convertor->getPoiTagListConvertor ( $data );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 获取酒店本地攻略标签列表
	 *
	 * @return Json
	 */
	public function getAdminPoiTagListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$limit = $this->getParamList ( 'limit' );
		$param ['limit'] = isset ( $limit ) ? $limit : null;
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		$data = $this->model->getPoiTagList ( $param );
		$count = $this->model->getPoiTagCount ( $param );
		$data = $this->convertor->getAdminPoiTagListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店本地攻略标签详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getPoiTagDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getPoiTagDetail ( $id );
			$data = $this->convertor->getPoiTagDetailConvertor ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改酒店本地攻略标签信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updatePoiTagByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
			$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
			$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
			$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
			$data = $this->model->updatePoiTagById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加酒店本地攻略标签信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addPoiTagAction() {
		$param = array ();
		$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
		$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
		$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
		$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
		$data = $this->model->addPoiTag ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
