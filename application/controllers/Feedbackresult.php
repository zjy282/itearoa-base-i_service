<?php
/**
 * 酒店问卷调查回答控制器类
 *
 */
class FeedbackResultController extends \BaseController {

	/**
	 *
	 * @var FeedbackResultModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_FeedbackResult
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new FeedbackResultModel ();
		$this->convertor = new Convertor_FeedbackResult ();
	}

	/**
	 * 获取酒店问卷调查回答列表
	 *
	 * @return Json
	 */
	public function getFeedbackResultListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$data = $this->model->getFeedbackResultList ( $param );
		$count = $this->model->getFeedbackResultCount ( $param );
		$data = $this->convertor->getFeedbackResultListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店问卷调查回答详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getFeedbackResultDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getFeedbackResultDetail ( $id );
			$data = $this->convertor->getFeedbackResultDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改酒店问卷调查回答信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateFeedbackResultByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['name'] = trim ( $this->getParamList ( 'name' ) );
			$data = $this->model->updateFeedbackResultById ( $param, $id );
			$data = $this->convertor->commonConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 添加酒店问卷调查回答信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addFeedbackResultAction() {
		$param = array ();
		$param ['answer'] = json_decode ( $this->getParamList ( 'answer' ), true );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['listid'] = intval ( $this->getParamList ( 'listid' ) );
		$param ['userid'] = Auth_Login::getToken ( $this->getParamList ( 'token' ) );
		if (empty ( $param ['answer'] )) {
			$this->throwException ( 2, '回答不能为空或者格式错误' );
		}
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 2, '物业ID不能为空' );
		}
		if (empty ( $param ['listid'] )) {
			$this->throwException ( 3, '表单ID不能为空' );
		}
		if (empty ( $param ['userid'] )) {
			$this->throwException ( 4, 'token验证失败' );
		}
		$param ['answer'] = json_encode ( $param ['answer'] );
		$data = $this->model->addFeedbackResult ( $param );
		if (! $data) {
			$this->throwException ( 4, '保存失败' );
		}
		$this->echoSuccessData ( array ('id' => $data ) );
	}
}
