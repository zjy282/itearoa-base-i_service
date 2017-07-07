<?php

/**
 * RSS类别控制器类
 *
 */
class RssTypeController extends \BaseController {

    /**
     * @var RssTypeModel
     */
    private $model;
    /**
     * @var Convertor_RssType
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new RssTypeModel();
        $this->convertor = new Convertor_RssType();
    }

    /**
     * 获取RSS类别列表
     *
     * @return Json
     */
    public function getRssTypeListAction() {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 10));
        $data = $this->model->getRssTypeList($param);
        $count = $this->model->getRssTypeCount($param);
        $data = $this->convertor->getRssTypeListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取RSS类别详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getRssTypeDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getRssTypeDetail($id);
            $data = $this->convertor->getRssTypeDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改RSS类别信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateRssTypeByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['title'] = trim($this->getParamList('title'));
            $param ['title_en'] = trim($this->getParamList('title_en'));
            $data = $this->model->updateRssTypeById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加RSS类别信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addRssTypeAction() {
        $param = array();
        $param ['title'] = trim($this->getParamList('title'));
        $param ['title_en'] = trim($this->getParamList('title_en'));
        $data = $this->model->addRssType($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
