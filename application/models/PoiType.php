<?php

/**
 * Class PoiTypeModel
 * 本地攻略类型管理
 */
class PoiTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_PoiType();
    }

    /**
     * 获取PoiType列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiTypeList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['limit']) ? $paramList['limit'] = $param['limit'] : false;
        $paramList['page'] = $param['page'];
        return $this->dao->getPoiTypeList($paramList);
    }
    
    /**
     * 获取PoiType数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiTypeCount(array $param) {
    	$paramList = array();
    	$param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
    	return $this->dao->getPoiTypeCount($paramList);
    }

    /**
     * 根据id查询PoiType信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPoiTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPoiTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新PoiType信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePoiTypeById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = $param['title_lang1'];
            $info['title_lang2'] = $param['title_lang2'];
            $info['title_lang3'] = $param['title_lang3'];
            $info['hotelid'] = $param['hotelid'];
            $result = $this->dao->updatePoiTypeById($info, $id);
        }
        return $result;
    }

    /**
     * PoiType新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPoiType($param) {
		$info ['title_lang1'] = $param ['title_lang1'];
		$info ['title_lang2'] = $param ['title_lang2'];
		$info ['title_lang3'] = $param ['title_lang3'];
		$info ['hotelid'] = $param ['hotelid'];
        return $this->dao->addPoiType($info);
    }
}
