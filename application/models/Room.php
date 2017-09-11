<?php

/**
 * Class RoomModel
 * 房间管理
 */
class RoomModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Room();
    }

    /**
     * 获取Room列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getRoomList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['room'] ? $paramList['room'] = $param['room'] : false;
        $param['floor'] ? $paramList['floor'] = trim($param['floor']) : false;
        $param['typeid'] ? $paramList['typeid'] = intval($param['typeid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRoomList($paramList);
    }

    /**
     * 获取Room数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRoomCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['room'] ? $paramList['room'] = $param['room'] : false;
        $param['floor'] ? $paramList['floor'] = trim($param['floor']) : false;
        $param['typeid'] ? $paramList['typeid'] = intval($param['typeid']) : false;
        return $this->dao->getRoomCount($paramList);
    }

    /**
     * 根据id查询Room信息
     * @param int id 查询的主键
     * @return array
     */
    public function getRoomDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getRoomDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Room信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateRoomById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['floor']) ? $info['floor'] = $param['floor'] : false;
            isset($param['room']) ? $info['room'] = $param['room'] : false;
            isset($param['typeid']) ? $info['typeid'] = $param['typeid'] : false;
            isset($param['size']) ? $info['size'] = $param['size'] : false;
            $result = $this->dao->updateRoomById($info, $id);
        }
        return $result;
    }

    /**
     * Room新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addRoom($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['floor']) ? $info['floor'] = $param['floor'] : false;
        isset($param['room']) ? $info['room'] = $param['room'] : false;
        isset($param['typeid']) ? $info['typeid'] = $param['typeid'] : false;
        isset($param['size']) ? $info['size'] = $param['size'] : false;
        isset($param['createtime']) ? $info['createtime'] = $param['createtime'] : $info['createtime'] = $param['createtime'];
        return $this->dao->addRoom($info);
    }
}
