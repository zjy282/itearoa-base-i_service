<?php

/**
 * Class RoomtypeModel
 * 房型管理Model
 */
class RoomtypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Roomtype();
    }

    /**
     * 获取Roomtype列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getRoomtypeList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['title'] ? $paramList['title'] = intval($param['title']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRoomtypeList($paramList);
    }

    /**
     * 获取Roomtype数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRoomtypeCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['title'] ? $paramList['title'] = intval($param['title']) : false;
        return $this->dao->getRoomtypeCount($paramList);
    }

    /**
     * 根据id查询Roomtype信息
     * @param int id 查询的主键
     * @return array
     */
    public function getRoomtypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getRoomtypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Roomtype信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateRoomtypeById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            isset($param['size']) ? $info['size'] = $param['size'] : false;
            isset($param['panoramic']) ? $info['panoramic'] = $param['panoramic'] : false;
            isset($param['roomcount']) ? $info['roomcount'] = $param['roomcount'] : false;
            isset($param['personcount']) ? $info['personcount'] = $param['personcount'] : false;
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['bedtype_lang1']) ? $info['bedtype_lang1'] = $param['bedtype_lang1'] : false;
            isset($param['bedtype_lang2']) ? $info['bedtype_lang2'] = $param['bedtype_lang2'] : false;
            isset($param['bedtype_lang3']) ? $info['bedtype_lang3'] = $param['bedtype_lang3'] : false;
            isset($param['detail_lang1']) ? $info['detail_lang1'] = $param['detail_lang1'] : false;
            isset($param['detail_lang2']) ? $info['detail_lang2'] = $param['detail_lang2'] : false;
            isset($param['detail_lang3']) ? $info['detail_lang3'] = $param['detail_lang3'] : false;
            isset($param['resid_list']) ? $info['resid_list'] = $param['resid_list'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            $result = $this->dao->updateRoomtypeById($info, $id);
        }
        return $result;
    }

    /**
     * Roomtype新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addRoomtype($param) {
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        isset($param['size']) ? $info['size'] = $param['size'] : false;
        isset($param['panoramic']) ? $info['panoramic'] = $param['panoramic'] : false;
        isset($param['roomcount']) ? $info['roomcount'] = $param['roomcount'] : false;
        isset($param['personcount']) ? $info['personcount'] = $param['personcount'] : false;
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['bedtype_lang1']) ? $info['bedtype_lang1'] = $param['bedtype_lang1'] : false;
        isset($param['bedtype_lang2']) ? $info['bedtype_lang2'] = $param['bedtype_lang2'] : false;
        isset($param['bedtype_lang3']) ? $info['bedtype_lang3'] = $param['bedtype_lang3'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        $info['createtime'] = time();
        return $this->dao->addRoomtype($info);
    }
}
