<?php

/**
 * Class TelTypeModel
 * 电话黄页分类管理
 */
class TelTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_TelType();
    }

    /**
     * 获取TelType列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTelTypeList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['title'] ? $paramList['title'] = $param['title'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['islogin']) ? $paramList['islogin'] = intval($param['islogin']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getTelTypeList($paramList);
    }

    /**
     * 获取TelType数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTelTypeCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['title'] ? $paramList['title'] = intval($param['title']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['islogin']) ? $paramList['islogin'] = intval($param['islogin']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getTelTypeCount($paramList);
    }

    /**
     * 根据id查询TelType信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getTelTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getTelTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新TelType信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateTelTypeById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['islogin']) ? $info['islogin'] = $param['islogin'] : false;
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $result = $this->dao->updateTelTypeById($info, $id);
        }
        return $result;
    }

    /**
     * TelType新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addTelType($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['islogin']) ? $info['islogin'] = $param['islogin'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        return $this->dao->addTelType($info);
    }
}
