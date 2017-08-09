<?php

/**
 * 启动图控制器类
 *
 */
class AppImgController extends \BaseController {

    /**
     *
     * @var AppImgModel
     */
    private $model;

    /**
     *
     * @var Convertor_AppImg
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new AppImgModel ();
        $this->convertor = new Convertor_AppImg ();
    }

    /**
     * 获取启动图列表
     *
     * @return Json
     */
    public function getAppImgListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->getAppImgList($param);
        $count = $this->model->getAppImgCount($param);
        $data = $this->convertor->getAppImgListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取启动图详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getAppImgDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getAppImgDetail($id);
            $data = $this->convertor->getAppImgDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改启动图信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateAppImgByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['pic'] = $this->getParamList('pic');
            $param ['status'] = $this->getParamList('status');
            $param ['groupid'] = intval($this->getParamList('groupid'));
            $data = $this->model->updateAppImgById($param, $id);
            $data = $this->convertor->statusConvertor(array('id' => $data));
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加启动图信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addAppImgAction() {
        $param = array();
        $param ['pickey'] = $this->getParamList('pickey');
        $param ['status'] = intval($this->getParamList('status'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->addAppImg($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 获取最新可用的启动图
     *
     * @return array
     */
    public function getAvailableAppImgAction() {
        $data = $this->model->getAvailableAppImg();
        $data = $this->convertor->availableAppImgConvertor($data);
        $this->echoSuccessData($data);
    }
}
