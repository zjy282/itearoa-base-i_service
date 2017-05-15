<?php
/**
 * app启动消息阅读记录控制器类
 *
 */
class AppstartMsgLogController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new AppstartMsgLogModel ();
		$this->convertor = new Convertor_AppstartMsgLog ();
	}

	/**
	 * 获取app启动消息阅读记录列表
	 *
	 * @return Json
	 */
	public function getAppstartMsgLogListAction() {
		$param = array ();
		$param ['name'] = trim ( $this->getParamList ( 'name' ) );
		$data = $this->model->getAppstartMsgLogList ( $param );
		$data = $this->convertor->getAppstartMsgLogListConvertor ( $data );
		$this->echoJson ( $data );
	}

	/**
	 * 根据id获取app启动消息阅读记录详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getAppstartMsgLogDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getAppstartMsgLogDetail ( $id );
			$data = $this->convertor->getAppstartMsgLogDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改app启动消息阅读记录信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateAppstartMsgLogByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['name'] = trim ( $this->getParamList ( 'name' ) );
			$data = $this->model->updateAppstartMsgLogById ( $param, $id );
			$data = $this->convertor->commonConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 添加app启动消息阅读记录信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addAppstartMsgLogAction() {
		$param = array ();
		$param ['platform'] = intval ( $this->getParamList ( 'platform' ) );
		$param ['msgid'] = intval ( $this->getParamList ( 'msgid' ) );
		$param ['identity'] = strval ( $this->getParamList ( 'identity' ) );
		if (empty ( $param ['platform'] ) || empty ( $param ['msgid'] ) || empty ( $param ['identity'] )) {
			$this->throwException ( 2, '入参错误' );
		}
		$checkStatus = $this->model->getAppstartMsgLogList ( $param );
		if (! $checkStatus) {
			$data = $this->model->addAppstartMsgLog ( $param );
		} else {
			$data = $checkStatus [0] ['id'];
		}
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}
}
