<?php

class ShoppingController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new ShoppingModel();
        $this->convertor = new Convertor_Shopping();
    }

    /**
     * 获取Shopping列表
     *
     * @return Json
     */
    public function getShoppingListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['tagid'] = intval($this->getParamList('tagid'));
        $this->getPageParam($param);
        $shoppingList = $this->model->getShoppingList($param);
        $shoppingCount = $this->model->getShoppingCount($param);
        $shoppingTagModel = new ShoppingTagModel();
        $tagList = $shoppingTagModel->getShoppingTagList($param);
        $data = $this->convertor->getShoppingListConvertor($shoppingList, $tagList, $shoppingCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Shopping详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getShoppingDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getShoppingDetail($id);
            $data = $this->convertor->getShoppingDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改Shopping信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateShoppingByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateShoppingById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加Shopping信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addShoppingAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addShopping($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }
}
