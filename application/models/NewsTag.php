<?php

/**
 * Class NewsTagModel
 * 新闻标签管理
 */
class NewsTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_NewsTag();
    }

    /**
     * 获取NewsTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsTagList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getNewsTagList($paramList);
    }
    
    /**
     * 获取NewsTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsTagCount(array $param) {
    	$paramList = array();
    	$param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
    	return $this->dao->getNewsTagCount($paramList);
    }

    /**
     * 根据id查询NewsTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getNewsTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getNewsTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新NewsTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateNewsTagById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = $param['title_lang1'];
            $info['title_lang2'] = $param['title_lang2'];
            $info['title_lang3'] = $param['title_lang3'];
            $info['hotelid'] = $param['hotelid'];
            $result = $this->dao->updateNewsTagById($info, $id);
        }
        return $result;
    }

    /**
     * NewsTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addNewsTag($param) {
       	$info ['title_lang1'] = $param ['title_lang1'];
		$info ['title_lang2'] = $param ['title_lang2'];
		$info ['title_lang3'] = $param ['title_lang3'];
		$info ['hotelid'] = $param ['hotelid'];
        return $this->dao->addNewsTag($info);
    }
}
