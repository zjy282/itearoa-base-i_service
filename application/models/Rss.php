<?php

/**
 * Class RssModel
 * RSS管理
 */
class RssModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Rss();
    }

    /**
     * 获取Rss列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRssList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['typeid'] ? $paramList['typeid'] = intval($param['typeid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRssList($paramList);
    }

    /**
     * 获取Rss数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRssCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['typeid'] ? $paramList['typeid'] = intval($param['typeid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getRssCount($paramList);
    }

    /**
     * 根据id查询Rss信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getRssDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getRssDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Rss信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateRssById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['name_zh']) ? $info['name_zh'] = $param['name_zh'] : false;
            isset($param['name_en']) ? $info['name_en'] = $param['name_en'] : false;
            isset($param['rss']) ? $info['rss'] = $param['rss'] : false;
            isset($param['typeid']) ? $info['typeid'] = $param['typeid'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $info['updatetime'] = time();
            $result = $this->dao->updateRssById($info, $id);
        }
        return $result;
    }

    /**
     * Rss新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addRss($param) {
        isset($param['name_zh']) ? $info['name_zh'] = $param['name_zh'] : false;
        isset($param['name_en']) ? $info['name_en'] = $param['name_en'] : false;
        isset($param['rss']) ? $info['rss'] = $param['rss'] : false;
        isset($param['typeid']) ? $info['typeid'] = $param['typeid'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        $info['createtime'] = $info['updatetime'] = time();
        return $this->dao->addRss($info);
    }
}
