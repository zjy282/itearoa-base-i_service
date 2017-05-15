<?php
/**
 * 后台用户操作日志控制器类
 *
 */
class OperateLogController extends \BaseController {

	/**
	 *
	 * @var OperateLogModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_OperateLog
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new OperateLogModel ();
		$this->convertor = new Convertor_OperateLog ();
	}

	/**
	 * 获取后台用户操作日志列表
	 *
	 * @return Json
	 */
	public function getOperateLogListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['operatorid'] = intval ( $this->getParamList ( 'operatorid' ) );
		$param ['module'] = intval ( $this->getParamList ( 'module' ) );
		$param ['code'] = $this->getParamList ( 'code' );
		$param ['admintype'] = intval ( $this->getParamList ( 'admintype' ) );
		$param ['admintypeid'] = intval ( $this->getParamList ( 'admintypeid' ) );
		$data = $this->model->getOperateLogList ( $param );
		$count = $this->model->getOperateLogCount ( $param );
		$data = $this->convertor->getOperateLogListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取后台用户操作日志详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getOperateLogDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getOperateLogDetail ( $id );
			$data = $this->convertor->getOperateLogDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 添加后台用户操作日志信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addOperateLogAction() {
		$param = array ();
		$param ['operatorid'] = intval ( $this->getParamList ( 'operatorid' ) );
		$param ['dataid'] = trim ( $this->getParamList ( 'dataid' ) );
		$param ['code'] = intval ( $this->getParamList ( 'code' ) );
		$param ['msg'] = trim ( $this->getParamList ( 'msg' ) );
		$param ['module'] = intval ( $this->getParamList ( 'module' ) );
		$param ['action'] = intval ( $this->getParamList ( 'action' ) );
		$param ['ip'] = trim ( $this->getParamList ( 'ip' ) );
		$param ['miscinfo'] = trim ( $this->getParamList ( 'miscinfo' ) );
		$param ['admintype'] = intval ( $this->getParamList ( 'admintype' ) );
		$param ['admintypeid'] = intval ( $this->getParamList ( 'admintypeid' ) );
		$insertId = $this->model->addOperateLog ( $param );
		$this->echoSuccessData ( array ('dataId' => $insertId ) );
	}
}
