<?php

/**
 * 集团新闻标签控制器类
 *
 */
class GroupNewsTagController extends \BaseController
{

    /**
     * @var GroupNewsTagModel
     */
    private $model;

    /**
     * @var Convertor_GroupNewsTag
     */
    private $convertor;

    public function init()
    {
        parent::init();
        $this->model = new GroupNewsTagModel ();
        $this->convertor = new Convertor_GroupNewsTag ();
    }

    /**
     * 后台获取集团新闻标签列表
     *
     * @return Json
     */
    public function getAdminTagListAction()
    {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param['lang'] = trim($this->getParamList('lang', Enum_Lang::CHINESE));
        $param ['page'] = intval($this->getParamList('page', 1));
        $limit = $this->getParamList('limit');
        $param ['limit'] = isset ($limit) ? $limit : null;
        $list = $this->model->getNewsTagList($param);
        $count = $this->model->getNewsTagCount($param);
        $data = $this->convertor->getAdminTagListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 获取集团新闻标签列表
     *
     * @return Json
     */
    public function getTagListAction()
    {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param['lang'] = trim($this->getParamList('lang', Enum_Lang::CHINESE));
        if (empty($param ['groupid'])) {
            $this->throwException(2, '集团ID不能为空');
        }
        $list = $this->model->getNewsTagList($param);
        $count = $this->model->getNewsTagCount($param);
        $data = $this->convertor->getTagListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取集团新闻标签详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTagDetailAction()
    {
        $id = intval($this->getParamList('id'));
        $param['lang'] = trim($this->getParamList('lang', Enum_Lang::CHINESE));
        if ($id) {
            $data = $this->model->getNewsTagDetail($id);
            $data = $this->convertor->getTagDetailConvertor($data, $param);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改集团新闻标签信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateNewsTagByIdAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
            $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
            $param ['groupid'] = trim($this->getParamList('groupid'));
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
    public function addNewsTagAction()
    {
        $param = array();
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['groupid'] = trim($this->getParamList('groupid'));
        $data = $this->model->addNewsTag($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
