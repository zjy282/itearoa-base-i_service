<?php

/**
 * Class PanoramicModel
 * 物业全景管理Model
 */
class PanoramicModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Panoramic();
    }

    /**
     * 获取Panoramic列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPanoramicList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['title'] ? $paramList['title'] = trim($param['title']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPanoramicList($paramList);
    }

    /**
     * 获取Panoramic数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPanoramicCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['title'] ? $paramList['title'] = trim($param['title']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getPanoramicCount($paramList);
    }

    /**
     * 根据id查询Panoramic信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPanoramicDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPanoramicDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Panoramic信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePanoramicById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['panoramic']) ? $info['panoramic'] = $param['panoramic'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $result = $this->dao->updatePanoramicById($info, $id);
        }
        return $result;
    }

    /**
     * Panoramic新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPanoramic($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['panoramic']) ? $info['panoramic'] = $param['panoramic'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        return $this->dao->addPanoramic($info);
    }
}
