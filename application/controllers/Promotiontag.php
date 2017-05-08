<?php

class PromotionTagController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new PromotionTagModel();
        $this->convertor = new Convertor_PromotionTag();
    }

    /**
     * 获取PromotionTag列表
     *
     * @return Json
     */
    public function getAdminTagListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$limit = $this->getParamList ('limit');
		$param ['limit'] = isset($limit) ? $limit : null;
        $list = $this->model->getPromotionTagList($param);
        $count = $this->model->getPromotionTagCount($param);
        $data = $this->convertor->getAdminTagListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取PromotionTag详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTagDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getPromotionTagDetail($id);
            $data = $this->convertor->getTagDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改Promotion信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updatePromotionTagByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['title_lang1'] = trim($this->getParamList('title_lang1'));
            $param['title_lang2'] = trim($this->getParamList('title_lang2'));
            $param['title_lang3'] = trim($this->getParamList('title_lang3'));
            $param['hotelid'] = trim($this->getParamList('hotelid'));
            $data = $this->model->updatePromotionTagById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加Promotion信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addPromotionTagAction() {
        $param = array();
		$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
		$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
		$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
		$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
        $data = $this->model->addPromotionTag($param);
        $data = $this->convertor->statusConvertor($data);
        $this->echoSuccessData($data);
    }
}
