<?php

class ShoppingController extends \BaseController {

    /**
     * @var ShoppingModel
     */
    private $model;
    /**
     * @var Convertor_Shopping
     */
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
        $data = $this->convertor->getEffectiveShoppingListConvertor($shoppingList, $tagList, $shoppingCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 获取Activity列表
     *
     * @return Json
     */
    public function getListAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['tagid'] = intval($this->getParamList('tagid'));
        $param['title'] = trim($this->getParamList('title'));
        $param['status'] = $this->getParamList('status');
        if (is_null($param['status'])) {
            unset($param['status']);
        }
        $this->getPageParam($param);
        $activityList = $this->model->getShoppingList($param);
        $activityCount = $this->model->getShoppingCount($param);
        $data = $this->convertor->getShoppingListConvertor($activityList, $activityCount, $param);
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
            $param['title_lang1'] = $this->getParamList('title_lang1');
            $param['title_lang2'] = $this->getParamList('title_lang2');
            $param['title_lang3'] = $this->getParamList('title_lang3');
            $param['introduct_lang1'] = $this->getParamList('introduct_lang1');
            $param['introduct_lang2'] = $this->getParamList('introduct_lang2');
            $param['introduct_lang3'] = $this->getParamList('introduct_lang3');
            $param['tagid'] = $this->getParamList('tagid');
            $param['pic'] = $this->getParamList('pic');
            $param['detail_lang1'] = $this->getParamList('detail_lang1');
            $param['detail_lang2'] = $this->getParamList('detail_lang2');
            $param['detail_lang3'] = $this->getParamList('detail_lang3');
            $param['hotelid'] = $this->getParamList('hotelid');
            $data = $this->model->updateShoppingById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
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
        $param['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param['introduct_lang1'] = trim($this->getParamList('introduct_lang1'));
        $param['introduct_lang2'] = trim($this->getParamList('introduct_lang2'));
        $param['introduct_lang3'] = trim($this->getParamList('introduct_lang3'));
        $param['tagid'] = intval($this->getParamList('tagid'));
        $param['pic'] = trim($this->getParamList('pic'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $data = $this->model->addShopping($param);
        $data = $this->convertor->statusConvertor(array(
            'id' => $data
        ));
        $this->echoSuccessData($data);
    }
}
