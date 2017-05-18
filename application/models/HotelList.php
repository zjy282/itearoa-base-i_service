<?php

/**
 * Class HotelListModel
 * 物业列表管理Model
 */
class HotelListModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_HotelList();
    }

    /**
     * 获取HotelList列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHotelListList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['name'] ? $paramList['name'] = intval($param['name']) : false;
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getHotelListList($paramList);
    }

    /**
     * 获取HotelList数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHotelListCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['name'] ? $paramList['name'] = intval($param['name']) : false;
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getHotelListCount($paramList);
    }

    /**
     * 根据id查询HotelList信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getHotelListDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getHotelListDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新HotelList信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateHotelListById($param, $id) {
        $result = false;
        if ($id) {
            !is_null($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
            !is_null($param['propertyinterfid']) ? $info['propertyinterfid'] = $param['propertyinterfid'] : false;
            !is_null($param['localpic']) ? $info['localpic'] = $param['localpic'] : false;
            !is_null($param['lng']) ? $info['lng'] = $param['lng'] : false;
            !is_null($param['lat']) ? $info['lat'] = $param['lat'] : false;
            !is_null($param['cityid']) ? $info['cityid'] = $param['cityid'] : false;
            !is_null($param['tel']) ? $info['tel'] = $param['tel'] : false;
            !is_null($param['name_lang1']) ? $info['name_lang1'] = $param['name_lang1'] : false;
            !is_null($param['name_lang2']) ? $info['name_lang2'] = $param['name_lang2'] : false;
            !is_null($param['name_lang3']) ? $info['name_lang3'] = $param['name_lang3'] : false;
            !is_null($param['website']) ? $info['website'] = $param['website'] : false;
            !is_null($param['logo']) ? $info['logo'] = $param['logo'] : false;
            !is_null($param['index_background']) ? $info['index_background'] = $param['index_background'] : false;
            !is_null($param['localpic']) ? $info['localpic'] = $param['localpic'] : false;
            !is_null($param['voice_lang1']) ? $info['voice_lang1'] = $param['voice_lang1'] : false;
            !is_null($param['voice_lang2']) ? $info['voice_lang2'] = $param['voice_lang2'] : false;
            !is_null($param['voice_lang3']) ? $info['voice_lang3'] = $param['voice_lang3'] : false;
            !is_null($param['address_lang1']) ? $info['address_lang1'] = $param['address_lang1'] : false;
            !is_null($param['address_lang2']) ? $info['address_lang2'] = $param['address_lang2'] : false;
            !is_null($param['address_lang3']) ? $info['address_lang3'] = $param['address_lang3'] : false;
            !is_null($param['introduction_lang1']) ? $info['introduction_lang1'] = $param['introduction_lang1'] : false;
            !is_null($param['introduction_lang2']) ? $info['introduction_lang2'] = $param['introduction_lang2'] : false;
            !is_null($param['introduction_lang3']) ? $info['introduction_lang3'] = $param['introduction_lang3'] : false;
            !is_null($param['status']) ? $info['status'] = $param['status'] : false;
            !is_null($param['lang_list']) ? $info['lang_list'] = $param['lang_list'] : false;
            !is_null($param['bookurl']) ? $info['bookurl'] = $param['bookurl'] : false;
            $result = $this->dao->updateHotelListById($info, $id);
        }
        return $result;
    }

    /**
     * HotelList新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addHotelList($param) {
        !is_null($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        !is_null($param['propertyinterfid']) ? $info['propertyinterfid'] = $param['propertyinterfid'] : false;
        !is_null($param['lng']) ? $info['lng'] = $param['lng'] : false;
        !is_null($param['localpic']) ? $info['localpic'] = $param['localpic'] : false;
        !is_null($param['lat']) ? $info['lat'] = $param['lat'] : false;
        !is_null($param['cityid']) ? $info['cityid'] = $param['cityid'] : false;
        !is_null($param['tel']) ? $info['tel'] = $param['tel'] : false;
        !is_null($param['name_lang1']) ? $info['name_lang1'] = $param['name_lang1'] : false;
        !is_null($param['name_lang2']) ? $info['name_lang2'] = $param['name_lang2'] : false;
        !is_null($param['name_lang3']) ? $info['name_lang3'] = $param['name_lang3'] : false;
        !is_null($param['website']) ? $info['website'] = $param['website'] : false;
        !is_null($param['logo']) ? $info['logo'] = $param['logo'] : false;
        !is_null($param['index_background']) ? $info['index_background'] = $param['index_background'] : false;
        !is_null($param['localpic']) ? $info['localpic'] = $param['localpic'] : false;
        !is_null($param['voice_lang1']) ? $info['voice_lang1'] = $param['voice_lang1'] : false;
        !is_null($param['voice_lang2']) ? $info['voice_lang2'] = $param['voice_lang2'] : false;
        !is_null($param['voice_lang3']) ? $info['voice_lang3'] = $param['voice_lang3'] : false;
        !is_null($param['address_lang1']) ? $info['address_lang1'] = $param['address_lang1'] : false;
        !is_null($param['address_lang2']) ? $info['address_lang2'] = $param['address_lang2'] : false;
        !is_null($param['address_lang3']) ? $info['address_lang3'] = $param['address_lang3'] : false;
        !is_null($param['introduction_lang1']) ? $info['introduction_lang1'] = $param['introduction_lang1'] : false;
        !is_null($param['introduction_lang2']) ? $info['introduction_lang2'] = $param['introduction_lang2'] : false;
        !is_null($param['introduction_lang3']) ? $info['introduction_lang3'] = $param['introduction_lang3'] : false;
        !is_null($param['status']) ? $info['status'] = $param['status'] : false;
        !is_null($param['lang_list']) ? $info['lang_list'] = $param['lang_list'] : false;
        !is_null($param['bookurl']) ? $info['bookurl'] = $param['bookurl'] : false;
        return $this->dao->addHotelList($info);
    }
}
