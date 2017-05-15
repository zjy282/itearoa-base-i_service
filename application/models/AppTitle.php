<?php

/**
 * Class AppTitleModel
 * APP内多语言标题管理
 */
class AppTitleModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_AppTitle();
    }

    /**
     * 获取AppTitle列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppTitleList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['key'] ? $paramList['key'] = trim($param['key']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppTitleList($paramList);
    }

    /**
     * 获取AppTitle数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppTitleCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['key'] ? $paramList['key'] = trim($param['key']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getAppTitleCount($paramList);
    }

    /**
     * 根据id查询AppTitle信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getAppTitleDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAppTitleDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppTitle信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateAppTitleById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['key']) ? $info['key'] = $param['key'] : false;
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            $result = $this->dao->updateAppTitleById($info, $id);
        }
        return $result;
    }

    /**
     * AppTitle新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addAppTitle($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['key']) ? $info['key'] = $param['key'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        return $this->dao->addAppTitle($info);
    }
}
