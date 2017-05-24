<?php

/**
 * 酒店问卷调查控制器类
 *
 */
class FeedbackListController extends \BaseController {

    /**
     *
     * @var FeedbackListModel
     */
    private $model;

    /**
     *
     * @var Convertor_FeedbackList
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new FeedbackListModel ();
        $this->convertor = new Convertor_FeedbackList ();
    }

    /**
     * 获取酒店问卷调查列表
     *
     * @return Json
     */
    public function getFeedbackListAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        if (empty ($param ['hotelid'])) {
            $this->throwException(2, '物业ID不能为空');
        }
        $param ['status'] = 1;
        $data = $this->model->getFeedbackList($param);
        $data = $this->convertor->getFeedbackListConvertor($data);
        $this->echoSuccessData($data);
    }

    /**
     * 获取后台酒店问卷调查列表
     *
     * @return Json
     */
    public function getListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['name'] = trim($this->getParamList('name'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getFeedbackList($param);
        $count = $this->model->getFeedbackCount($param);
        $data = $this->convertor->getListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店问卷调查详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getFeedbackDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getFeedbackDetail($id);
            $data = $this->convertor->getFeedbackDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店问卷调查信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateFeedbackByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['name'] = $this->getParamList('name');
            $param ['sort'] = $this->getParamList('sort');
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updateFeedbackById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店问卷调查信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addFeedbackAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['name'] = trim($this->getParamList('name'));
        $param ['sort'] = trim($this->getParamList('sort'));
        $param ['status'] = intval($this->getParamList('status'));
        $data = $this->model->addFeedback($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
