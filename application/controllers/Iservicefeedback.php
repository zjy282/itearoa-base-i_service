<?php

/**
 * APP问题反馈控制器类
 *
 */
class IserviceFeedbackController extends \BaseController {

    /**
     *
     * @var IserviceFeedbackModel
     */
    private $model;

    /**
     *
     * @var Convertor_IserviceFeedback
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new IserviceFeedbackModel ();
        $this->convertor = new Convertor_IserviceFeedback ();
    }

    /**
     * 获取APP问题反馈列表
     *
     * @return Json
     */
    public function getIserviceFeedbackListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['email'] = intval($this->getParamList('email'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->getIserviceFeedbackList($param);
        $count = $this->model->getIserviceFeedbackCount($param);
        $data = $this->convertor->getIserviceFeedbackListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取APP问题反馈详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getIserviceFeedbackDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getIserviceFeedbackDetail($id);
            $data = $this->convertor->getIserviceFeedbackDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改APP问题反馈信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateIserviceFeedbackByIdAction() {
        $paramList = $this->getParamList(false);
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            isset ($paramList ['email']) ? $param ['email'] = trim($paramList ['email']) : false;
            isset ($paramList ['content']) ? $param ['content'] = trim($paramList ['content']) : false;
            $param ['groupid'] = intval($this->getParamList('groupid'));
            $data = $this->model->updateIserviceFeedbackById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加APP问题反馈信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addIserviceFeedbackAction() {
        $param = array();
        $param ['email'] = trim($this->getParamList('email'));
        $param ['content'] = trim($this->getParamList('content'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        if (empty ($param ['email'])) {
            $this->throwException(2, '联系邮箱不能为空');
        }
        if (empty ($param ['content'])) {
            $this->throwException(2, '反馈信息不能为空');
        }
        if (empty ($param ['groupid'])) {
            $this->throwException(2, '集团ID不能为空');
        }
        $param ['createtime'] = time();
        $data = $this->model->addIserviceFeedback($param);
        $this->echoSuccessData(array('orderId' => $data));
    }
}
