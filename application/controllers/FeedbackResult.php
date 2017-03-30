<?php

class FeedbackResultController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new FeedbackResultModel();
        $this->convertor = new Convertor_FeedbackResult();
    }

    /**
     * 获取FeedbackResult列表
     *
     * @return Json
     */
    public function getFeedbackResultListAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getFeedbackResultList($param);
        $data = $this->convertor->getFeedbackResultListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取FeedbackResult详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getFeedbackResultDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getFeedbackResultDetail($id);
            $data = $this->convertor->getFeedbackResultDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改FeedbackResult信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateFeedbackResultByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateFeedbackResultById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加FeedbackResult信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addFeedbackResultAction() {
        $param = array();
        $param['answer'] = json_decode($this->getParamList('answer'), true);
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['userid'] = Auth_Login::getToken($this->getParamList('token'));
        if (empty($param['answer'])) {
            $this->throwException(2, '回答不能为空或者格式错误');
        }
        if (empty($param['hotelid'])) {
            $this->throwException(2, '物业ID不能为空');
        }
        if (empty($param['userid'])) {
            $this->throwException(3, 'token验证失败');
        }
        $param['answer'] = json_encode($param['answer']);
        $data = $this->model->addFeedbackResult($param);
        if (! $data) {
            $this->throwException(4, '保存失败');
        }
        $this->echoSuccessData(array(
            'id' => $data
        ));
    }
}
