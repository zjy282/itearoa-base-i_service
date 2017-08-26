<?php

/**
 * 酒店电话黄页分类控制器类
 *
 */
class TelTypeController extends \BaseController {

    /**
     *
     * @var TelTypeModel
     */
    private $model;

    /**
     *
     * @var Convertor_TelType
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new TelTypeModel ();
        $this->convertor = new Convertor_TelType ();
    }

    /**
     * 获取酒店电话黄页分类列表
     *
     * @return Json
     */
    public function getTelTypeListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['title'] = trim($this->getParamList('title'));
        $param ['islogin'] = $this->getParamList('islogin');
        if (is_null($param ['islogin'])) {
            unset ($param ['islogin']);
        }
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getTelTypeList($param);
        $count = $this->model->getTelTypeCount($param);
        $data = $this->convertor->getTelTypeListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店电话黄页分类详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTelTypeDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getTelTypeDetail($id);
            $data = $this->convertor->getTelTypeDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店电话黄页分类信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateTelTypeByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['islogin'] = $this->getParamList('islogin');
            $param ['title_lang1'] = $this->getParamList('title_lang1');
            $param ['title_lang2'] = $this->getParamList('title_lang2');
            $param ['title_lang3'] = $this->getParamList('title_lang3');
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updateTelTypeById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店电话黄页分类信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addTelTypeAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['islogin'] = intval($this->getParamList('islogin'));
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param ['status'] = intval($this->getParamList('status'));
        $data = $this->model->addTelType($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
