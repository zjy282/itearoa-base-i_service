<?php

/**
 * 酒店新闻标签控制器类
 *
 */
class NewsTagController extends \BaseController {

    /**
     * @var NewsTagModel
     */
    private $model;

    /**
     * @var Convertor_NewsTag
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new NewsTagModel ();
        $this->convertor = new Convertor_NewsTag ();
    }

    /**
     * 获取酒店新闻标签列表
     *
     * @return Json
     */
    public function getTagListAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        if (empty($param ['hotelid'])) {
            $this->throwException(2, '物业ID不能为空');
        }
        $list = $this->model->getNewsTagList($param);
        $count = $this->model->getNewsTagCount($param);
        $data = $this->convertor->getTagListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 后台获取酒店新闻标签列表
     *
     * @return Json
     */
    public function getAdminTagListAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['page'] = intval($this->getParamList('page', 1));
        $limit = $this->getParamList('limit');
        $param ['limit'] = isset ($limit) ? $limit : null;
        $list = $this->model->getNewsTagList($param);
        $count = $this->model->getNewsTagCount($param);
        $data = $this->convertor->getAdminTagListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店新闻标签详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTagDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getNewsTagDetail($id);
            $data = $this->convertor->getTagDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改酒店新闻标签信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateNewsTagByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
            $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
            $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
            $param ['hotelid'] = trim($this->getParamList('hotelid'));
            $data = $this->model->updateNewsTagById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店新闻标签信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addNewsTagAction() {
        $param = array();
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param ['hotelid'] = trim($this->getParamList('hotelid'));
        $data = $this->model->addNewsTag($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
