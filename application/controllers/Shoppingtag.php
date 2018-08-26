<?php

/**
 * 体验购物标签控制器类
 */
class ShoppingTagController extends \BaseController
{

    /**
     *
     * @var ShoppingTagModel
     */
    private $model;

    /**
     *
     * @var Convertor_ShoppingTag
     */
    private $convertor;

    public function init()
    {
        parent::init();
        $this->model = new ShoppingTagModel ();
        $this->convertor = new Convertor_ShoppingTag ();
    }

    /**
     * 获取体验购物标签列表
     *
     */
    public function getShoppingTagListAction()
    {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 0));
        $param['id'] = intval($this->getParamList('id'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['status'] = $this->getParamList('status', 0);
        $param['parentid'] = $this->getParamList('parentid', 0);
        $param['withChild'] = boolval($this->getParamList('withchild', false));

        if ($param['status'] === 'all') {
            unset($param['status']);
        }
        if ($param['parentid'] === 'all') {
            unset($param['parentid']);
        }

        $data = $this->model->getShoppingTagList($param);
        $data = $this->convertor->getShoppingTagListConvertor($data, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取体验购物标签详情
     *
     * @param
     *            int id 获取详情信息的id
     */
    public function getShoppingTagDetailAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getShoppingTagDetail($id);
            $data = $this->convertor->getShoppingTagDetailConvertor($data);
            $this->echoSuccessData($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
    }

    /**
     * 根据id修改体验购物标签信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     */
    public function updateShoppingTagByIdAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['title_lang1'] = $this->getParamList('title_lang1');
            $param['title_lang2'] = $this->getParamList('title_lang2');
            $param['title_lang3'] = $this->getParamList('title_lang3');
            $param['pic'] = $this->getParamList('pic');
            $param['parentid'] = $this->getParamList('parentid');
            $param['status'] = $this->getParamList('status');
            $param['is_robot'] = $this->getParamList('is_robot');
            $param['staff_list'] = $this->getParamList('staff_list');

            $data = $this->model->updateShoppingTagById($param, $id);
            $data = $this->convertor->statusConvertor($data);
            $this->echoSuccessData($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
    }

    /**
     * 添加体验购物标签信息
     *
     * @param
     *            array param 需要新增的信息
     */
    public function addShoppingTagAction()
    {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param['pic'] = trim($this->getParamList('pic'));
        $param['parentid'] = intval($this->getParamList('parentid'));
        $param['status'] = intval($this->getParamList('status'));
        $param['is_robot'] = intval($this->getParamList('is_robot'));

        $data = $this->model->addShoppingTag($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
