<?php

/**
 * Class FloorModel
 * 楼层管理Model
 */
class FloorModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Floor();
    }

    /**
     * 获取Floor列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getFloorList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['floor'] ? $paramList['floor'] = trim($param['floor']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getFloorList($paramList);
    }

    /**
     * 获取Floor数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getFloorCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['floor'] ? $paramList['floor'] = trim($param['floor']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getFloorCount($paramList);
    }

    /**
     * 根据id查询Floor信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getFloorDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getFloorDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Floor信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateFloorById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            isset($param['floor']) ? $info['floor'] = $param['floor'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            isset($param['detail_lang1']) ? $info['detail_lang1'] = $param['detail_lang1'] : false;
            isset($param['detail_lang2']) ? $info['detail_lang2'] = $param['detail_lang2'] : false;
            isset($param['detail_lang3']) ? $info['detail_lang3'] = $param['detail_lang3'] : false;
            $result = $this->dao->updateFloorById($info, $id);
        }
        return $result;
    }

    /**
     * Floor新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addFloor($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['floor']) ? $info['floor'] = $param['floor'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        isset($param['detail_lang1']) ? $info['detail_lang1'] = $param['detail_lang1'] : false;
        isset($param['detail_lang2']) ? $info['detail_lang2'] = $param['detail_lang2'] : false;
        isset($param['detail_lang3']) ? $info['detail_lang3'] = $param['detail_lang3'] : false;
        return $this->dao->addFloor($info);
    }
}
