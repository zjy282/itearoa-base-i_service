<?php

/**
 * Class RoomResModel
 * 房间设施管理
 */
class RoomResModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_RoomRes();
    }

    /**
     * 获取RoomRes列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getRoomResList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['icon'] ? $paramList['icon'] = trim($param['icon']) : false;
        $param['name'] ? $paramList['name'] = trim($param['name']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRoomResList($paramList);
    }

    /**
     * 获取RoomRes数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRoomResCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['icon'] ? $paramList['icon'] = trim($param['icon']) : false;
        $param['name'] ? $paramList['name'] = trim($param['name']) : false;
        return $this->dao->getRoomResCount($paramList);
    }

    /**
     * 根据id查询RoomRes信息
     * @param int id 查询的主键
     * @return array
     */
    public function getRoomResDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getRoomResDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新RoomRes信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateRoomResById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            isset($param['icon']) ? $info['icon'] = $param['icon'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['name_lang1']) ? $info['name_lang1'] = $param['name_lang1'] : false;
            isset($param['name_lang2']) ? $info['name_lang2'] = $param['name_lang2'] : false;
            isset($param['name_lang3']) ? $info['name_lang3'] = $param['name_lang3'] : false;
            isset($param['introduct_lang1']) ? $info['introduct_lang1'] = $param['introduct_lang1'] : false;
            isset($param['introduct_lang2']) ? $info['introduct_lang2'] = $param['introduct_lang2'] : false;
            isset($param['introduct_lang3']) ? $info['introduct_lang3'] = $param['introduct_lang3'] : false;
            isset($param['detail_lang1']) ? $info['detail_lang1'] = $param['detail_lang1'] : false;
            isset($param['detail_lang2']) ? $info['detail_lang2'] = $param['detail_lang2'] : false;
            isset($param['detail_lang3']) ? $info['detail_lang3'] = $param['detail_lang3'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['video']) ? $info['video'] = $param['video'] : false;
            $result = $this->dao->updateRoomResById($info, $id);
        }
        return $result;
    }

    /**
     * RoomRes新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addRoomRes($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['icon']) ? $info['icon'] = $param['icon'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
        isset($param['name_lang1']) ? $info['name_lang1'] = $param['name_lang1'] : false;
        isset($param['name_lang2']) ? $info['name_lang2'] = $param['name_lang2'] : false;
        isset($param['name_lang3']) ? $info['name_lang3'] = $param['name_lang3'] : false;
        isset($param['introduct_lang1']) ? $info['introduct_lang1'] = $param['introduct_lang1'] : false;
        isset($param['introduct_lang2']) ? $info['introduct_lang2'] = $param['introduct_lang2'] : false;
        isset($param['introduct_lang3']) ? $info['introduct_lang3'] = $param['introduct_lang3'] : false;
        isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
        isset($param['video']) ? $info['video'] = $param['video'] : false;
        return $this->dao->addRoomRes($info);
    }
}
