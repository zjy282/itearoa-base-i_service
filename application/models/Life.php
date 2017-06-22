<?php

/**
 * Class LifeModel
 * 雅士阁生活管理
 */
class LifeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Life();
    }

    /**
     * 获取Life列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getLifeList(array $param) {
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['name'] ? $paramList['name'] = $param['name'] : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getLifeList($paramList);
    }

    /**
     * 获取Life数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getLifeCount(array $param) {
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['name'] ? $paramList['name'] = $param['name'] : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getLifeCount($paramList);
    }

    /**
     * 根据id查询Life信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getLifeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getLifeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Life信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateLifeById($param, $id) {
        $result = false;
        if ($id) {
            $info = array();
            isset($param ['hotelid']) ? $info ['hotelid'] = $param ['hotelid'] : false;
            isset($param ['typeid']) ? $info ['typeid'] = $param ['typeid'] : false;
            isset($param ['name_lang1']) ? $info ['name_lang1'] = $param ['name_lang1'] : false;
            isset($param ['name_lang2']) ? $info ['name_lang2'] = $param ['name_lang2'] : false;
            isset($param ['name_lang3']) ? $info ['name_lang3'] = $param ['name_lang3'] : false;
            isset($param ['detail_lang1']) ? $info ['detail_lang1'] = $param ['detail_lang1'] : false;
            isset($param ['detail_lang2']) ? $info ['detail_lang2'] = $param ['detail_lang2'] : false;
            isset($param ['detail_lang3']) ? $info ['detail_lang3'] = $param ['detail_lang3'] : false;
            isset($param ['address_lang1']) ? $info ['address_lang1'] = $param ['address_lang1'] : false;
            isset($param ['address_lang2']) ? $info ['address_lang2'] = $param ['address_lang2'] : false;
            isset($param ['address_lang3']) ? $info ['address_lang3'] = $param ['address_lang3'] : false;
            isset($param ['introduct_lang1']) ? $info ['introduct_lang1'] = $param ['introduct_lang1'] : false;
            isset($param ['introduct_lang2']) ? $info ['introduct_lang2'] = $param ['introduct_lang2'] : false;
            isset($param ['introduct_lang3']) ? $info ['introduct_lang3'] = $param ['introduct_lang3'] : false;
            isset($param ['tel']) ? $info ['tel'] = $param ['tel'] : false;
            isset($param ['lat']) ? $info ['lat'] = $param ['lat'] : false;
            isset($param ['lng']) ? $info ['lng'] = $param ['lng'] : false;
            isset($param ['updatetime']) ? $info ['updatetime'] = $param ['updatetime'] : false;
            isset($param ['status']) ? $info ['status'] = $param ['status'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['video']) ? $info['video'] = $param['video'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            $result = $this->dao->updateLifeById($info, $id);
        }
        return $result;
    }

    /**
     * Life新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addLife($param) {
        $info = $param;
        return $this->dao->addLife($info);
    }
}
