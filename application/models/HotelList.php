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
        !is_null($param['propertyinterfid']) ? $paramList['propertyinterfid'] = intval($param['propertyinterfid']) : false;
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
     * 根据propertyinterfId查询物业信息
     *
     * @param
     *            int propertyinterfId 物业propertyinterfId
     * @return array
     */
    public function getHotelListDetailByPropertyinterfId($propertyinterfId) {
        $result = array();
        if ($propertyinterfId) {
            $result = $this->dao->getHotelListDetailByPropertyinterfId($propertyinterfId);
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
            $info = array();
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
            !is_null($param['listpic']) ? $info['listpic'] = $param['listpic'] : false;
            !is_null($param['voice_lang1']) ? $info['voice_lang1'] = $param['voice_lang1'] : false;
            !is_null($param['voice_lang2']) ? $info['voice_lang2'] = $param['voice_lang2'] : false;
            !is_null($param['voice_lang3']) ? $info['voice_lang3'] = $param['voice_lang3'] : false;
            !is_null($param['address_lang1']) ? $info['address_lang1'] = $param['address_lang1'] : false;
            !is_null($param['address_lang2']) ? $info['address_lang2'] = $param['address_lang2'] : false;
            !is_null($param['address_lang3']) ? $info['address_lang3'] = $param['address_lang3'] : false;
            !is_null($param['introduction_lang1']) ? $info['introduction_lang1'] = $param['introduction_lang1'] : false;
            !is_null($param['introduction_lang2']) ? $info['introduction_lang2'] = $param['introduction_lang2'] : false;
            !is_null($param['introduction_lang3']) ? $info['introduction_lang3'] = $param['introduction_lang3'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            !is_null($param['lang_list']) ? $info['lang_list'] = $param['lang_list'] : false;
            !is_null($param['bookurl']) ? $info['bookurl'] = $param['bookurl'] : false;
            !is_null($param['flighturl']) ? $info['flighturl'] = $param['flighturl'] : false;
            !is_null($param['surveyurl']) ? $info['surveyurl'] = $param['surveyurl'] : false;
            !is_null($param['robot_pic']) ? $info['robot_pic'] = $param['robot_pic'] : false;
            !is_null($param['washing_machine']) ? $info['washing_machine'] = $param['washing_machine'] : false;
            !is_null($param['invoice_id']) ? $info['invoice_id'] = trim($param['invoice_id']) : false;
            !is_null($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['rss']) ? $info['rss'] = $param['rss'] : false;
            if (!empty($info)) {
                $result = $this->dao->updateHotelListById($info, $id);
            }
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
        !is_null($param['listpic']) ? $info['listpic'] = $param['listpic'] : false;
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
        !is_null($param['invoice_id']) ? $info['invoice_id'] = trim($param['invoice_id']) : false;
        !is_null($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
        return $this->dao->addHotelList($info);
    }

    /**
     * Sort the hotel list by distance
     *
     * @param array $list
     * @param float $lng
     * @param float $lat
     */
    public function sortByDistance(array &$list, float $lng, float $lat)
    {
        $sortArray = array();
        foreach ($list as &$item) {
            $radLat1 = deg2rad($lat);
            $radLng1 = deg2rad($lng);
            $radLat2 = deg2rad($item['lat']);
            $radLng2 = deg2rad($item['lng']);
            $a = $radLat1 - $radLat2;
            $b = $radLng1 - $radLng2;
            $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
            $item['distance'] = $distance;
            $sortArray[] = $distance;
        }
        array_multisort($sortArray, $list);
    }
}
