<?php

/**
 * Class PromotionTagModel
 * 促销标签管理
 */
class PromotionTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_PromotionTag();
    }

    /**
     * 获取PromotionTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPromotionTagList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['limit']) ? $paramList['limit'] = $param['limit'] : false;
        isset($param['page']) ? $paramList['page'] = $param['page'] : false;
        return $this->dao->getPromotionTagList($paramList);
    }

    /**
     * 获取PromotionTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPromotionTagCount(array $param) {
    	$paramList = array();
    	$param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
    	return $this->dao->getPromotionTagCount($paramList);
    }
    
    /**
     * 根据id查询PromotionTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPromotionTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPromotionTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新PromotionTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePromotionTagById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = $param['title_lang1'];
            $info['title_lang2'] = $param['title_lang2'];
            $info['title_lang3'] = $param['title_lang3'];
            $info['hotelid'] = $param['hotelid'];
            $result = $this->dao->updatePromotionTagById($info, $id);
        }
        return $result;
    }

    /**
     * PromotionTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPromotionTag($param) {
       	$info ['title_lang1'] = $param ['title_lang1'];
		$info ['title_lang2'] = $param ['title_lang2'];
		$info ['title_lang3'] = $param ['title_lang3'];
		$info ['hotelid'] = $param ['hotelid'];
        return $this->dao->addPromotionTag($info);
    }
}
