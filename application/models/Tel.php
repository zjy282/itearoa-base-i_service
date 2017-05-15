<?php

/**
 * Class TelModel
 * 电话黄页管理
 */
class TelModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Tel();
    }

    /**
     * 获取Tel列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTelList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['title'] ? $paramList['title'] = $param['title'] : false;
        $param['tel'] ? $paramList['tel'] = $param['tel'] : false;
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getTelList($paramList);
    }

    /**
     * 获取Tel数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTelCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['title'] ? $paramList['title'] = $param['title'] : false;
        $param['tel'] ? $paramList['tel'] = $param['tel'] : false;
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getTelCount($paramList);
    }

    /**
     * 根据id查询Tel信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getTelDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getTelDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Tel信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateTelById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            isset($param['tel']) ? $info['tel'] = $param['tel'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            isset($param['typeid']) ? $info['typeid'] = $param['typeid'] : false;
            $result = $this->dao->updateTelById($info, $id);
        }
        return $result;
    }

    /**
     * Tel新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addTel($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        isset($param['tel']) ? $info['tel'] = $param['tel'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['typeid']) ? $info['typeid'] = $param['typeid'] : false;
        return $this->dao->addTel($info);
    }
}
