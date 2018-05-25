<?php

/**
 * Class ShoppingModel
 * 购物信息管理
 */
class ShoppingModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Shopping();
    }

    /**
     * 获取Shopping列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['tagid'] ? $paramList['tagid'] = intval($param['tagid']) : false;
        $param['title'] ? $paramList['title'] = intval($param['title']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $param['limit'] ? $paramList['limit'] = $param['limit'] : false;
        $paramList['page'] = $param['page'];
        return $this->dao->getShoppingList($paramList);
    }

    /**
     * 获取Shopping数量
     *
     * @param array
     * @return int
     */

    /**
     * @param array $param
     * @return array|int
     */
    public function getShoppingCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['tagid'] ? $paramList['tagid'] = intval($param['tagid']) : false;
        $param['title'] ? $paramList['title'] = intval($param['title']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getShoppingCount($paramList);
    }

    /**
     * 根据id查询Shopping信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShoppingDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShoppingDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Shopping信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShoppingById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            isset($param['introduct_lang1']) ? $info['introduct_lang1'] = $param['introduct_lang1'] : false;
            isset($param['introduct_lang2']) ? $info['introduct_lang2'] = $param['introduct_lang2'] : false;
            isset($param['introduct_lang3']) ? $info['introduct_lang3'] = $param['introduct_lang3'] : false;
            isset($param['tagid']) ? $info['tagid'] = $param['tagid'] : false;
            isset($param['price']) ? $info['price'] = $param['price'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            isset($param['detail_lang1']) ? $info['detail_lang1'] = $param['detail_lang1'] : false;
            isset($param['detail_lang2']) ? $info['detail_lang2'] = $param['detail_lang2'] : false;
            isset($param['detail_lang3']) ? $info['detail_lang3'] = $param['detail_lang3'] : false;
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['video']) ? $info['video'] = $param['video'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;

            $result = $this->dao->updateShoppingById($info, $id);
        }
        return $result;
    }

    /**
     * Shopping新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addShopping($param) {
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        isset($param['introduct_lang1']) ? $info['introduct_lang1'] = $param['introduct_lang1'] : false;
        isset($param['introduct_lang2']) ? $info['introduct_lang2'] = $param['introduct_lang2'] : false;
        isset($param['introduct_lang3']) ? $info['introduct_lang3'] = $param['introduct_lang3'] : false;
        isset($param['tagid']) ? $info['tagid'] = $param['tagid'] : false;
        isset($param['price']) ? $info['price'] = $param['price'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
        isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
        isset($param['video']) ? $info['video'] = $param['video'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        $info['createtime'] = time();
        return $this->dao->addShopping($info);
    }
}
