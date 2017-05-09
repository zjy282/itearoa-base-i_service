<?php

class PromotionController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new PromotionModel ();
        $this->convertor = new Convertor_Promotion ();
    }

    /**
     * 获取Promotion列表
     *
     * @return Json
     */
    public function getPromotionListAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['tagid'] = intval($this->getParamList('tagid'));
        $this->getPageParam($param);
        $promotionList = $this->model->getPromotionList($param);
        $promotionCount = $this->model->getPromotionCount($param);
        $promotionTagModel = new PromotionTagModel ();
        $tagList = $promotionTagModel->getPromotionTagList($param);
        $this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getPromotionListConvertor($promotionList, $tagList, $promotionCount, $param) : $data = $this->convertor->getAdminPromotionListConvertor($promotionList, $tagList, $promotionCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Promotion详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getPromotionDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getPromotionDetail($id);
            $this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getPromotionDetailConvertor($data) : $data = $this->convertor->getAdminPromotionListConvertor($data);
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
    public function updatePromotionByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = trim($this->getParamList('hotelid'));
            $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
            $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
            $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
            $param ['article_lang1'] = trim($this->getParamList('article_lang1'));
            $param ['article_lang2'] = trim($this->getParamList('article_lang2'));
            $param ['article_lang3'] = trim($this->getParamList('article_lang3'));
            $param ['tagid'] = trim($this->getParamList('tagid'));
            $param ['updatetime'] = time();
            $data = $this->model->updatePromotionById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Promotion信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addPromotionAction() {
        $param = array();
        $param ['hotelid'] = trim($this->getParamList('hotelid'));
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param ['article_lang1'] = trim($this->getParamList('article_lang1'));
        $param ['article_lang2'] = trim($this->getParamList('article_lang2'));
        $param ['article_lang3'] = trim($this->getParamList('article_lang3'));
        $param ['tagid'] = trim($this->getParamList('tagid'));
        $param ['updatetime'] = time();
        $data = $this->model->addPromotion($param);
        $data = $this->convertor->statusConvertor(array(
            'id' => $data
        ));
        $this->echoJson($data);
    }
}
