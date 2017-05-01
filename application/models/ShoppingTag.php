<?php

class ShoppingTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShoppingTag();
    }

    /**
     * 获取ShoppingTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingTagList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShoppingTagList($paramList);
    }

    /**
     * 获取ShoppingTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingTagCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getShoppingTagCount($paramList);
    }

    /**
     * 根据id查询ShoppingTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShoppingTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShoppingTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ShoppingTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShoppingTagById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = strval($param['title_lang1']);
            $info['title_lang2'] = strval($param['title_lang2']);
            $info['title_lang3'] = strval($param['title_lang3']);
            $result = $this->dao->updateShoppingTagById($info, $id);
        }
        return $result;
    }

    /**
     * ShoppingTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addShoppingTag($param) {
        $info['hotelid'] = intval($param['hotelid']);
        $info['title_lang1'] = strval($param['title_lang1']);
        $info['title_lang2'] = strval($param['title_lang2']);
        $info['title_lang3'] = strval($param['title_lang3']);
        return $this->dao->addShoppingTag($info);
    }
}
