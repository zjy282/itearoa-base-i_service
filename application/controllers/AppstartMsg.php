<?php

class AppstartMsgController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new AppstartMsgModel();
        $this->convertor = new Convertor_AppstartMsg();
    }

    /**
     * 获取AppstartMsg列表
     *
     * @return Json
     */
    public function getAppstartMsgListAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getAppstartMsgList($param);
        $data = $this->convertor->getAppstartMsgListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取AppstartMsg详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getAppstartMsgDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getAppstartMsgDetail($id);
            $data = $this->convertor->getAppstartMsgDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改AppstartMsg信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateAppstartMsgByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateAppstartMsgById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加AppstartMsg信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addAppstartMsgAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addAppstartMsg($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 获取当前可用的APP启动消息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function getEffectiveAppStartMsgAction() {
        $param = array();
        $groupId = intval($this->getParamList('groupid'));
        $hotelId = intval($this->getParamList('hotelid'));
        $platform = intval($this->getParamList('platform'));
        $identity = strval($this->getParamList('identity'));
        
        if (empty($groupId) || empty($hotelId) || empty($platform) || empty($identity)) {
            $this->throwException(2, '参数错误');
        }
        
        // 获取物业可用信息
        $hotelMsg = $this->model->getAppstartMsgList(array(
            'status' => 1,
            'type' => 1,
            'limit' => 5,
            'dataid' => $hotelId
        ));
        // 获取集团可用信息
        $groupMsg = $this->model->getAppstartMsgList(array(
            'status' => 1,
            'type' => 2,
            'limit' => 5,
            'dataid' => $hotelId
        ));
        $msgList = array_merge($hotelMsg, $groupMsg);
        $megIdList = array_column($msgList, 'id');
        
        // 检查设备是否已经接收过广告
        $appStartMsgLogModel = new AppstartMsgLogModel();
        $msgLogHistory = $appStartMsgLogModel->getAppstartMsgLogList(array(
            'msgid' => $megIdList,
            'platform' => $platform,
            'identity' => $identity
        ));
        $msgLogHistoryMsgId = array_column($msgLogHistory, 'msgid');
        $data = $this->convertor->getEffectiveAppStartMsgConvertor($msgList, $msgLogHistoryMsgId);
        if ($data['list']) {
            $appStartMsgLogModel->addAppstartMsgLog(array(
                'msgid' => $data['list'][0]['msgId'],
                'platform' => $platform,
                'identity' => $identity
            ));
        }
        $this->echoSuccessData($data);
    }
}
