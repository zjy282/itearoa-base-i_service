<?php

/**
 * Class LifeTypeModel
 * 雅士阁生活类型管理
 */
class LifeTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_LifeType();
    }

    /**
     * 获取LifeType列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getLifeTypeList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['limit']) ? $paramList['limit'] = $param['limit'] : false;
        isset($param['page']) ? $paramList['page'] = $param['page'] : false;
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        return $this->dao->getLifeTypeList($paramList);
    }

    /**
     * 获取LifeType数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getLifeTypeCount(array $param) {
        $paramList = array();
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        return $this->dao->getLifeTypeCount($paramList);
    }

    /**
     * 根据id查询LifeType信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getLifeTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getLifeTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新LifeType信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateLifeTypeById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = $param['title_lang1'];
            $info['title_lang2'] = $param['title_lang2'];
            $info['title_lang3'] = $param['title_lang3'];
            $info['hotelid'] = $param['hotelid'];
            $result = $this->dao->updateLifeTypeById($info, $id);
        }
        return $result;
    }

    /**
     * LifeType新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addLifeType($param) {
        $info ['title_lang1'] = $param ['title_lang1'];
        $info ['title_lang2'] = $param ['title_lang2'];
        $info ['title_lang3'] = $param ['title_lang3'];
        $info ['hotelid'] = $param ['hotelid'];
        return $this->dao->addLifeType($info);
    }
}
