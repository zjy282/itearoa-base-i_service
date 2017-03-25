<?php

class LifeController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new LifeModel();
        $this->convertor = new Convertor_Life();
    }

    /**
     * 获取Life列表
     *
     * @return Json
     */
    public function getLifeListAction() {
        $param = array();
        $param['typeid'] = intval($this->getParamList('typeid'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $this->getPageParam($param);
        
        if (empty($param['hotelid'])) {
            $this->throwException(2, '入参错误');
        }
        
        $poiList = $this->model->getLifeList($param);
        $poiCount = $this->model->getLifeCount($param);
        $data = $this->convertor->getLifeListConvertor($poiList, $poiCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Life详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getLifeDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getLifeDetail($id);
            $data = $this->convertor->getLifeDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Life信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateLifeByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateLifeById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Life信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addLifeAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addLife($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }
}
