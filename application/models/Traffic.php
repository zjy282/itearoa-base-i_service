<?php

/**
 * Class TrafficModel
 * 交通信息管理
 */
class TrafficModel extends \BaseModel {

    /**
     * @var Dao_Traffic
     */
    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Traffic();
    }

    /**
     * 获取Traffic列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTrafficList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getTrafficList($paramList);
    }

    /**
     * 获取Traffic数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTrafficCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getTrafficCount($paramList);
    }

    /**
     * 根据id查询Traffic信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getTrafficDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getTrafficDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Traffic信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateTrafficById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['introduct_lang1']) ? $info['introduct_lang1'] = $param['introduct_lang1'] : false;
            isset($param['introduct_lang2']) ? $info['introduct_lang2'] = $param['introduct_lang2'] : false;
            isset($param['introduct_lang3']) ? $info['introduct_lang3'] = $param['introduct_lang3'] : false;
            isset($param['detail_lang1']) ? $info['detail_lang1'] = $param['detail_lang1'] : false;
            isset($param['detail_lang2']) ? $info['detail_lang2'] = $param['detail_lang2'] : false;
            isset($param['detail_lang3']) ? $info['detail_lang3'] = $param['detail_lang3'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['video']) ? $info['video'] = $param['video'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $result = $this->dao->updateTrafficById($info, $id);
        }
        return $result;
    }

    /**
     * Traffic新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addTraffic($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['introduct_lang1']) ? $info['introduct_lang1'] = $param['introduct_lang1'] : false;
        isset($param['introduct_lang2']) ? $info['introduct_lang2'] = $param['introduct_lang2'] : false;
        isset($param['introduct_lang3']) ? $info['introduct_lang3'] = $param['introduct_lang3'] : false;
        isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
        isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
        isset($param['video']) ? $info['video'] = $param['video'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        return $this->dao->addTraffic($info);
    }
}
