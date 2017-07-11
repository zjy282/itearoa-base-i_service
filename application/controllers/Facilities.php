<?php

/**
 * 酒店设施控制器类
 *
 */
class FacilitiesController extends \BaseController {

    /**
     *
     * @var FacilitiesModel
     */
    private $model;

    /**
     *
     * @var Convertor_Facilities
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new FacilitiesModel ();
        $this->convertor = new Convertor_Facilities ();
    }

    /**
     * 获取酒店设施列表
     *
     * @return Json
     */
    public function getFacilitiesListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['name'] = trim($this->getParamList('name'));
        $param ['icon'] = trim($this->getParamList('icon'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getFacilitiesList($param);
        $count = $this->model->getFacilitiesCount($param);
        $data = $this->convertor->getFacilitiesListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店设施详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getFacilitiesDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getFacilitiesDetail($id);
            $data = $this->convertor->getFacilitiesDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店设施信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateFacilitiesByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['status'] = $this->getParamList('status');
            $param ['name_lang1'] = $this->getParamList('name_lang1');
            $param ['name_lang2'] = $this->getParamList('name_lang2');
            $param ['name_lang3'] = $this->getParamList('name_lang3');
            $param ['introduct_lang1'] = $this->getParamList('introduct_lang1');
            $param ['introduct_lang2'] = $this->getParamList('introduct_lang2');
            $param ['introduct_lang3'] = $this->getParamList('introduct_lang3');
            $param ['detail_lang1'] = $this->getParamList('detail_lang1');
            $param ['detail_lang2'] = $this->getParamList('detail_lang2');
            $param ['detail_lang3'] = $this->getParamList('detail_lang3');
            $param ['icon'] = $this->getParamList('icon');
            $param ['pdf'] = $this->getParamList('pdf');
            $param ['video'] = $this->getParamList('video');
            $param ['pic'] = $this->getParamList('pic');
            $param ['sort'] = $this->getParamList('sort');
            $data = $this->model->updateFacilitiesById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店设施信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addFacilitiesAction() {
        $param = array();
        $param ['icon'] = trim($this->getParamList('icon'));
        $param ['name_lang1'] = trim($this->getParamList('name_lang1'));
        $param ['name_lang2'] = trim($this->getParamList('name_lang2'));
        $param ['name_lang3'] = trim($this->getParamList('name_lang3'));
        $param ['status'] = intval($this->getParamList('status'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['introduct_lang1'] = trim($this->getParamList('introduct_lang1'));
        $param ['introduct_lang2'] = trim($this->getParamList('introduct_lang2'));
        $param ['introduct_lang3'] = trim($this->getParamList('introduct_lang3'));
        $param ['pdf'] = trim($this->getParamList('pdf'));
        $param ['video'] = trim($this->getParamList('video'));
        $param ['pic'] = trim($this->getParamList('pic'));
        $param ['sort'] = intval($this->getParamList('sort'));
        $data = $this->model->addFacilities($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
