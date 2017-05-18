<?php

/**
 * Class PoiTagModel
 * 本地攻略标签管理
 */
class PoiTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_PoiTag();
    }

    /**
     * 获取PoiTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiTagList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['limit']) ? $paramList['limit'] = $param['limit'] : false;
        $paramList['page'] = $param['page'];
        return $this->dao->getPoiTagList($paramList);
    }
    
    /**
     * 获取PoiTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiTagCount(array $param) {
    	$paramList = array();
    	$param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
    	return $this->dao->getPoiTagCount($paramList);
    }

    /**
     * 根据id查询PoiTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPoiTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPoiTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新PoiTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePoiTagById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = $param['title_lang1'];
            $info['title_lang2'] = $param['title_lang2'];
            $info['title_lang3'] = $param['title_lang3'];
            $info['hotelid'] = $param['hotelid'];
            $result = $this->dao->updatePoiTagById($info, $id);
        }
        return $result;
    }

    /**
     * PoiTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPoiTag($param) {
		$info ['title_lang1'] = $param ['title_lang1'];
		$info ['title_lang2'] = $param ['title_lang2'];
		$info ['title_lang3'] = $param ['title_lang3'];
		$info ['hotelid'] = $param ['hotelid'];
        return $this->dao->addPoiTag($info);
    }
}
