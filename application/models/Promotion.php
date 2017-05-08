<?php

class PromotionModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Promotion();
    }

    /**
     * 获取Promotion列表信息
     * 
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPromotionList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['tagid'] ? $paramList['tagid'] = intval($param['tagid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPromotionList($paramList);
    }

    /**
     * 获取Promotion数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPromotionCount(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['tagid'] ? $paramList['tagid'] = intval($param['tagid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getPromotionCount($paramList);
    }

    /**
     * 根据id查询Promotion信息
     * 
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPromotionDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPromotionDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Promotion信息
     * 
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePromotionById($param, $id) {
        $result = false;
        if ($id) {
            $info = $param;
            $result = $this->dao->updatePromotionById($info, $id);
        }
        return $result;
    }

    /**
     * Promotion新增信息
     * 
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPromotion($param) {
        $info = $param;
        return $this->dao->addPromotion($info);
    }
}
