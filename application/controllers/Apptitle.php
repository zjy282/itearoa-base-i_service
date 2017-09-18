<?php

/**
 * 酒店APP标题控制器类
 *
 */
class AppTitleController extends \BaseController {

    /**
     *
     * @var AppTitleModel
     */
    private $model;

    /**
     *
     * @var Convertor_AppTitle
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new AppTitleModel ();
        $this->convertor = new Convertor_AppTitle ();
    }

    /**
     * 获取酒店APP标题列表
     *
     * @return Json
     */
    public function getAppTitleListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['key'] = trim($this->getParamList('key'));
        $data = $this->model->getAppTitleList($param);
        $count = $this->model->getAppTitleCount($param);
        $data = $this->convertor->getAppTitleListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店APP标题详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getAppTitleDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getAppTitleDetail($id);
            $data = $this->convertor->getAppTitleDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店APP标题信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateAppTitleByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['key'] = $this->getParamList('key');
            $param ['title_lang1'] = $this->getParamList('title_lang1');
            $param ['title_lang2'] = $this->getParamList('title_lang2');
            $param ['title_lang3'] = $this->getParamList('title_lang3');
            $checkKey = $this->model->getAppTitleList(array('key' => $param ['key'], 'hotelid' => $param ['hotelid']));
            $keyIdList = array_column($checkKey, 'id');
            if (count($keyIdList) > 1 || (count($keyIdList) == 1 && !in_array($id, $keyIdList))) {
                $this->throwException(2, 'KEY已经存在');
            }
            $data = $this->model->updateAppTitleById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店APP标题信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addAppTitleAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['key'] = trim($this->getParamList('key'));
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $checkKeyCount = $this->model->getAppTitleCount(array('key' => $param ['key'], 'hotelid' => $param ['hotelid']));
        if ($checkKeyCount > 0) {
            $this->throwException(2, 'KEY已经存在');
        }
        $data = $this->model->addAppTitle($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * APP获取物业标题信息
     *
     * @return json
     */
    public function getHotelAppTitleListAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        if (empty ($param ['hotelid'])) {
            $this->throwException(2, '物业ID错误');
        }
        $data = $this->model->getAppTitleList($param);
        $data = $this->convertor->hotelAppTitleListConvertor($data);
        $this->echoSuccessData($data);
    }
}
