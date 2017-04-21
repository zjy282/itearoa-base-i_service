<?php

class LifeTypeController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new LifeTypeModel();
        $this->convertor = new Convertor_LifeType();
    }

    /**
     * 获取LifeType列表
     *
     * @return Json
     */
    public function getLifeTypeListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        if (empty($param['hotelid'])) {
            $this->throwException(2, '物业ID不能为空');
        }
        $data = $this->model->getLifeTypeList($param);
        $data = $this->convertor->getLifeTypeListConvertor($data);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取LifeType详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getLifeTypeDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getLifeTypeDetail($id);
            $data = $this->convertor->getLifeTypeDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改LifeType信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateLifeTypeByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateLifeTypeById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加LifeType信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addLifeTypeAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addLifeType($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }
}
