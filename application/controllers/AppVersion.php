<?php

class AppVersionController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new AppVersionModel();
        $this->convertor = new Convertor_AppVersion();
    }

    /**
     * 获取AppVersion列表
     *
     * @return Json
     */
    public function getAppVersionListAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getAppVersionList($param);
        $data = $this->convertor->getAppVersionListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取AppVersion详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getAppVersionDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getAppVersionDetail($id);
            $data = $this->convertor->getAppVersionDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改AppVersion信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateAppVersionByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateAppVersionById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加AppVersion信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addAppVersionAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addAppVersion($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据设备获取APP最新的版本信息
     *
     * @param
     *            int platform 设备类型 1IOS，2安卓
     * @return Json
     */
    public function getLatestAppVersionByPlatformAction() {
        $param = array();
        $param['platform'] = intval($this->getParamList('platform'));
        $data = $this->model->getLatestAppVersionByPlatform($param);
        $data = $this->convertor->lastAppVersionConvertor($data);
        $this->echoSuccessData($data);
    }
}
