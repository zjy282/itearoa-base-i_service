<?php

/**
 * APP版本管理控制器类
 *
 */
class AppVersionController extends \BaseController {

    /**
     *
     * @var AppVersionModel
     */
    private $model;

    /**
     *
     * @var Convertor_AppVersion
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new AppVersionModel ();
        $this->convertor = new Convertor_AppVersion ();
    }

    /**
     * 获取APP版本管理列表
     *
     * @return Json
     */
    public function getAppVersionListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['platform'] = $this->getParamList('platform');
        $param ['forced'] = $this->getParamList('forced');
        $param ['latest'] = $this->getParamList('latest');
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->getAppVersionList($param);
        $count = $this->model->getAppVersionCount($param);
        $data = $this->convertor->getAppVersionListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取APP版本管理详情
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
     * 根据id修改APP版本管理信息
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
            $param ['platform'] = intval($this->getParamList('platform'));
            $param ['forced'] = intval($this->getParamList('forced'));
            $param ['version'] = $this->getParamList('version');
            $param ['description'] = $this->getParamList('description');
            $param ['latest'] = intval($this->getParamList('latest'));
            $param ['groupid'] = intval($this->getParamList('groupid'));
            $data = $this->model->updateAppVersionById($param, $id);
            $data = $this->convertor->statusConvertor(array('id' => $data));
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加APP版本管理信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addAppVersionAction() {
        $param = array();
        $param ['platform'] = intval($this->getParamList('platform'));
        $param ['forced'] = intval($this->getParamList('forced'));
        $param ['version'] = $this->getParamList('version');
        $param ['description'] = $this->getParamList('description');
        $param ['latest'] = intval($this->getParamList('latest'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->addAppVersion($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
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
        $param ['groupid'] = intval($this->getParamList('groupid'));
        if (empty ($param ['groupid'])) {
            $this->throwException(2, '集团ID不能为空');
        }
        $param ['platform'] = intval($this->getParamList('platform'));
        $data = $this->model->getLatestAppVersionByPlatform($param);
        $data = $this->convertor->lastAppVersionConvertor($data);
        $this->echoSuccessData($data);
    }
}
