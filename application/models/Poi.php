<?php

class PoiModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Poi();
    }

    /**
     * 获取Poi列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiList(array $param) {
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPoiList($paramList);
    }

    /**
     * 获取Poi数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiCount(array $param) {
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getPoiCount($paramList);
    }

    /**
     * 根据id查询Poi信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPoiDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPoiDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Poi信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePoiById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updatePoiById($info, $id);
        }
        return $result;
    }

    /**
     * Poi新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPoi($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addPoi($info);
    }
}
