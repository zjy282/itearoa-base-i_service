<?php

/**
 * APP启动广告图控制器类
 *
 */
class AppstartPicController extends \BaseController {

    /**
     *
     * @var AppstartPicModel
     */
    private $model;

    /**
     *
     * @var Convertor_AppstartPic
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new AppstartPicModel ();
        $this->convertor = new Convertor_AppstartPic ();
    }

    /**
     * 获取APP启动广告图列表
     *
     * @return Json
     */
    public function getAppstartPicListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getAppstartPicList($param);
        $count = $this->model->getAppstartPicCount($param);
        $data = $this->convertor->getAppstartPicListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取APP启动广告图详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getAppstartPicDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getAppstartPicDetail($id);
            $data = $this->convertor->getAppstartPicDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改APP启动广告图信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateAppstartPicByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['pic'] = $this->getParamList('pic');
            $param ['status'] = $this->getParamList('status');
            $param ['link'] = $this->getParamList('link');
            $data = $this->model->updateAppstartPicById($param, $id);
            $data = $this->convertor->statusConvertor(array('id' => $data));
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加APP启动广告图信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addAppstartPicAction() {
        $param = array();
        $param ['pic'] = $this->getParamList('pic');
        $param ['status'] = intval($this->getParamList('status'));
        $param ['link'] = $this->getParamList('link');
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->addAppstartPic($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 获取当前可用的APP广告图
     *
     * @return Json
     */
    public function getEffectiveAppStartPicAction() {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        if (empty ($param ['groupid'])) {
            $this->throwException(2, '集团ID不能为空');
        }
        $param ['limit'] = 1;
        $param ['status'] = 1;
        $data = $this->model->getAppstartPicList($param);
        $data = $this->convertor->getEffectiveAppStartPicConvertor($data);
        $this->echoSuccessData($data);
    }
}
