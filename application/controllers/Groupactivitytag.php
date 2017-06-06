<?php

/**
 * 活动标签控制器类
 */
class GroupActivityTagController extends \BaseController {

    /**
     *
     * @var GroupActivityTagModel
     */
    private $model;

    /**
     *
     * @var Convertor_GroupActivityTag
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new GroupActivityTagModel ();
        $this->convertor = new Convertor_GroupActivityTag ();
    }

    /**
     * 获取活动标签列表
     *
     * @return Json
     */
    public function getActivityTagListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getActivityTagList($param);
        $count = $this->model->getActivityTagCount($param);
        $data = $this->convertor->getActivityTagListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取活动标签详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getActivityTagDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getActivityTagDetail($id);
            $data = $this->convertor->getActivityTagDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改活动标签信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateActivityTagByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['title'] = trim($this->getParamList('title'));
            $data = $this->model->updateActivityTagById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加活动标签信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addActivityTagAction() {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['title'] = trim($this->getParamList('title'));
        $data = $this->model->addActivityTag($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
