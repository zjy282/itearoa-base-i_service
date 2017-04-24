<?php

class ActivityController extends \BaseController {

    /**
     * @var ActivityModel
     */
    private $model;
    /**
     * @var Convertor_Activity
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new ActivityModel();
        $this->convertor = new Convertor_Activity();
    }

    /**
     * 获取可用Activity列表
     *
     * @return Json
     */
    public function getEffectiveActivityListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['groupid'] = intval($this->getParamList('groupid'));
        $param['tagid'] = intval($this->getParamList('tagid'));
        $param['status'] = 1;
        $this->getPageParam($param);
        $activityList = $this->model->getActivityList($param);
        $activityCount = $this->model->getActivityCount($param);
        $activityTagModel = new ActivityTagModel();
        $tagList = $activityTagModel->getActivityTagList($param);
        $data = $this->convertor->getEffectiveActivityListConvertor($activityList, $tagList, $activityCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 获取Activity列表
     *
     * @return Json
     */
    public function getActivityListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['groupid'] = intval($this->getParamList('groupid'));
        $param['tagid'] = intval($this->getParamList('tagid'));
        $param['status'] = $this->getParamList('status');
        if (is_null($param['status'])) {
            unset($param['status']);
        }
        $this->getPageParam($param);
        $activityList = $this->model->getActivityList($param);
        $activityCount = $this->model->getActivityCount($param);
        $data = $this->convertor->getActivityListConvertor($activityList, $activityCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Activity详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getActivityDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getActivityDetail($id);
            $data = $this->convertor->getActivityDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Activity信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateActivityByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateActivityById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Activity信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addActivityAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addActivity($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }
}
