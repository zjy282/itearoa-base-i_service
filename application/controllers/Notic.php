<?php

class NoticController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new NoticModel();
        $this->convertor = new Convertor_Notic();
    }

    /**
     * 获取Notic列表
     *
     * @return Json
     */
    public function getNoticListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['tagid'] = intval($this->getParamList('tagid'));
        $this->getPageParam($param);
        $newsList = $this->model->getNoticList($param);
        $newsCount = $this->model->getNoticCount($param);
        $newsTagModel = new NoticTagModel();
        $tagList = $newsTagModel->getNoticTagList($param);
        $data = $this->convertor->getNoticListConvertor($newsList, $tagList, $newsCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Notic详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getNoticDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getNoticDetail($id);
            $data = $this->convertor->getNoticDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Notic信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateNoticByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateNoticById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Notic信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addNoticAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addNotic($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }
}
