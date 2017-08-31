<?php

/**
 *  酒店交通信息控制器类
 *
 */
class TrafficController extends \BaseController {

    /**
     *
     * @var TrafficModel
     */
    private $model;

    /**
     *
     * @var Convertor_Traffic
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new TrafficModel ();
        $this->convertor = new Convertor_Traffic ();
    }

    /**
     * 获取酒店交通信息列表
     *
     * @return Json
     */
    public function getTrafficListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getTrafficList($param);
        $count = $this->model->getTrafficCount($param);
        $data = $this->convertor->getTrafficListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店交通详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTrafficDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getTrafficDetail($id);
            $data = $this->convertor->getTrafficDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店交通信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateTrafficByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['introduct_lang1'] = $this->getParamList('introduct_lang1');
            $param ['introduct_lang2'] = $this->getParamList('introduct_lang2');
            $param ['introduct_lang3'] = $this->getParamList('introduct_lang3');
            $param ['detail_lang1'] = $this->getParamList('detail_lang1');
            $param ['detail_lang2'] = $this->getParamList('detail_lang2');
            $param ['detail_lang3'] = $this->getParamList('detail_lang3');
            $param ['sort'] = $this->getParamList('sort');
            $param ['pdf'] = $this->getParamList('pdf');
            $param ['video'] = $this->getParamList('video');
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updateTrafficById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店交通信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addTrafficAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['introduct_lang1'] = trim($this->getParamList('introduct_lang1'));
        $param ['introduct_lang2'] = trim($this->getParamList('introduct_lang2'));
        $param ['introduct_lang3'] = trim($this->getParamList('introduct_lang3'));
        $param ['sort'] = intval($this->getParamList('sort'));
        $param ['pdf'] = trim($this->getParamList('pdf'));
        $param ['video'] = trim($this->getParamList('video'));
        $param ['status'] = intval($this->getParamList('status'));
        $data = $this->model->addTraffic($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
