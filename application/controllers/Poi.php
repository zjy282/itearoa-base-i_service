<?php

class PoiController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new PoiModel();
        $this->convertor = new Convertor_Poi();
    }

    /**
     * 获取Poi列表
     *
     * @return Json
     */
    public function getPoiListAction() {
        $param = array();
        $param['typeid'] = intval($this->getParamList('typeid'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $this->getPageParam($param);
        
        if (empty($param['hotelid'])) {
            $this->throwException(2, '入参错误');
        }
        
        $poiList = $this->model->getPoiList($param);
        $poiCount = $this->model->getPoiCount($param);
        $data = $this->convertor->getPoiListConvertor($poiList, $poiCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Poi详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getPoiDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getPoiDetail($id);
            $data = $this->convertor->getPoiDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Poi信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updatePoiByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updatePoiById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Poi信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addPoiAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addPoi($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }
}
