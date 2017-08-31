<?php

/**
 * 物业全景控制器类
 *
 */
class PanoramicController extends \BaseController {

    /**
     *
     * @var PanoramicModel
     */
    private $model;

    /**
     *
     * @var Convertor_Panoramic
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new PanoramicModel ();
        $this->convertor = new Convertor_Panoramic ();
    }

    /**
     * 获取物业全景列表
     *
     * @return Json
     */
    public function getPanoramicListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['title'] = trim($this->getParamList('title'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getPanoramicList($param);
        $count = $this->model->getPanoramicCount($param);
        $data = $this->convertor->getPanoramicListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取物业全景详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getPanoramicDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getPanoramicDetail($id);
            $data = $this->convertor->getPanoramicDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改物业全景信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updatePanoramicByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['panoramic'] = $this->getParamList('panoramic');
            $param ['pic'] = $this->getParamList('pic');
            $param ['title_lang1'] = $this->getParamList('title_lang1');
            $param ['title_lang2'] = $this->getParamList('title_lang2');
            $param ['title_lang3'] = $this->getParamList('title_lang3');
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updatePanoramicById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加物业全景信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addPanoramicAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['panoramic'] = trim($this->getParamList('panoramic'));
        $param ['pic'] = trim($this->getParamList('pic'));
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param ['status'] = intval($this->getParamList('status'));
        $data = $this->model->addPanoramic($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
