<?php

class IserviceFeedbackController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new IserviceFeedbackModel();
        $this->convertor = new Convertor_IserviceFeedback();
    }

    /**
     * 获取IserviceFeedback列表
     *
     * @return Json
     */
    public function getIserviceFeedbackListAction() {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 5));
        $data = $this->model->getIserviceFeedbackList($param);
        $data = $this->convertor->getIserviceFeedbackListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取IserviceFeedback详情
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
     * 根据id修改IserviceFeedback信息
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
            isset($paramList['email']) ? $param['email'] = trim($paramList['email']) : false;
            isset($paramList['content']) ? $param['content'] = trim($paramList['content']) : false;
            $data = $this->model->updateIserviceFeedbackById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加IserviceFeedback信息
     * 
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addIserviceFeedbackAction() {
        $param = array();
        $param['email'] = trim($this->getParamList('email'));
        $param['content'] = trim($this->getParamList('content'));
        if (empty($param['email'])) {
            $this->throwException(2, '联系邮箱不能为空');
        }
        
        if (empty($param['content'])) {
            $this->throwException(2, '反馈信息不能为空');
        }
        $param['createtime'] = time();
        $data = $this->model->addIserviceFeedback($param);
        $this->echoSuccessData(array(
            'orderId' => $data
        ));
    }
}
