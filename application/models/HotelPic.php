<?php

/**
 * Class HotelPicModel
 * 物业图片信息Model
 */
class HotelPicModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_HotelPic();
    }

    /**
     * 获取HotelPic列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHotelPicList(array $param) {
        $paramList = array();
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getHotelPicList($paramList);
    }

    /**
     * 获取HotelPic数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHotelPicCount(array $param) {
        $paramList = array();
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getHotelPicCount($paramList);
    }

    /**
     * 根据id查询HotelPic信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getHotelPicDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getHotelPicDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新HotelPic信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateHotelPicById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            $result = $this->dao->updateHotelPicById($info, $id);
        }
        return $result;
    }

    /**
     * HotelPic新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addHotelPic($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        return $this->dao->addHotelPic($info);
    }
}
