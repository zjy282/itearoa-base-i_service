<?php
/**
 * app启动消息控制器类
 *
 */
class AppstartMsgController extends \BaseController {

	/**
	 *
	 * @var AppstartMsgModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_AppstartMsg
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new AppstartMsgModel ();
		$this->convertor = new Convertor_AppstartMsg ();
	}

	/**
	 * 获取app启动消息列表
	 *
	 * @return Json
	 */
	public function getAppstartMsgListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page' ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['id'] = intval ( $this->getParamList ( 'id' ) );
		$param ['type'] = intval ( $this->getParamList ( 'type' ) );
		$param ['dataid'] = intval ( $this->getParamList ( 'dataid' ) );
		$param ['status'] = $this->getParamList ( 'status' );
		if (is_null ( $param ['status'] )) {
			unset ( $param ['status'] );
		}
		$data = $this->model->getAppstartMsgList ( $param );
		$count = $this->model->getAppstartMsgCount ( $param );
		$data = $this->convertor->getAppstartMsgListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取app启动消息详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getAppstartMsgDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getAppstartMsgDetail ( $id );
			$data = $this->convertor->getAppstartMsgDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改app启动消息信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateAppstartMsgByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['type'] = $this->getParamList ( 'type' );
			$param ['dataid'] = $this->getParamList ( 'dataid' );
			$param ['pic'] = $this->getParamList ( 'pic' );
			$param ['msg'] = $this->getParamList ( 'msg' );
			$param ['url'] = $this->getParamList ( 'url' );
			$param ['status'] = $this->getParamList ( 'status' );
			$data = $this->model->updateAppstartMsgById ( $param, $id );
			$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加app启动消息信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addAppstartMsgAction() {
		$param = array ();
		$param ['type'] = intval ( $this->getParamList ( 'type' ) );
		$param ['dataid'] = intval ( $this->getParamList ( 'dataid' ) );
		$param ['pic'] = $this->getParamList ( 'pic' );
		$param ['msg'] = $this->getParamList ( 'msg' );
		$param ['url'] = $this->getParamList ( 'url' );
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$data = $this->model->addAppstartMsg ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 获取当前可用的APP启动消息
	 *
	 */
    public function getEffectiveAppStartMsgAction()
    {
        $groupId = intval($this->getParamList('groupid'));
        $hotelId = intval($this->getParamList('hotelid'));
        $platform = intval($this->getParamList('platform'));
        $identity = strval($this->getParamList('identity'));
        if (empty ($groupId) || empty ($hotelId) || empty ($platform) || empty ($identity)) {
            $this->throwException(2, '参数错误');
        }
        // 获取物业可用信息
        $hotelMsg = $this->model->getAppstartMsgList(array('status' => AppstartMsgModel::STATUS_ENABLE, 'type' => AppstartMsgModel::TYPE_HOTEL, 'limit' => 5, 'dataid' => $hotelId));
        // 获取集团可用信息
        $groupMsg = $this->model->getAppstartMsgList(array('status' => AppstartMsgModel::STATUS_ENABLE, 'type' => AppstartMsgModel::TYPE_GROUP, 'limit' => 5, 'dataid' => $groupId));
        $msgList = array_merge($hotelMsg, $groupMsg);
        $megIdList = array_column($msgList, 'id');
        // 检查设备是否已经接收过广告
        $appStartMsgLogModel = new AppstartMsgLogModel ();
        $msgLogHistory = $appStartMsgLogModel->getAppstartMsgLogList(array('msgid' => $megIdList, 'platform' => $platform, 'identity' => $identity));
        $msgLogHistoryMsgId = array_column($msgLogHistory, 'msgid');
        $data = $this->convertor->getEffectiveAppStartMsgConvertor($msgList, $msgLogHistoryMsgId);

        foreach ($data['list'] as $item) {
//            $appStartMsgLogModel->addAppstartMsgLog(array('msgid' => $item['msgId'], 'platform' => $platform, 'identity' => $identity));
        }
        $this->echoSuccessData($data);
    }
}
