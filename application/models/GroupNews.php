<?php

/**
 * Class GroupNewsModel
 * 新闻管理
 */
class GroupNewsModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_GroupNews ();
    }

    /**
     * 获取GroupNews列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsList(array $param) {
        isset ($param ['groupid']) ? $paramList ['groupid'] = intval($param ['groupid']) : false;
        $param ['tagid'] ? $paramList ['tagid'] = intval($param ['tagid']) : false;
        $param ['id'] ? $paramList ['id'] = intval($param ['id']) : false;
        $param ['title'] ? $paramList ['title'] = $param ['title'] : false;
        isset ($param ['status']) ? $paramList ['status'] = intval($param ['status']) : false;
        $paramList ['limit'] = $param ['limit'];
        $paramList ['page'] = $param ['page'];
        return $this->dao->getNewsList($paramList);
    }

    /**
     * 获取News数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsCount(array $param) {
        isset ($param ['groupid']) ? $paramList ['groupid'] = intval($param ['groupid']) : false;
        $param ['tagid'] ? $paramList ['tagid'] = intval($param ['tagid']) : false;
        isset ($param ['status']) ? $paramList ['status'] = intval($param ['status']) : false;
        return $this->dao->getNewsCount($paramList);
    }

    /**
     * 根据id查询News信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getNewsDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getNewsDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新GroupNews信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateNewsById($param, $id) {
        $result = false;
        if ($id) {
            $info = array();
            isset($param ['groupid']) ? $info ['groupid'] = $param ['groupid'] : false;
            isset($param ['status']) ? $info ['status'] = $param ['status'] : false;
            isset($param ['title']) ? $info ['title'] = $param ['title'] : false;
            isset($param ['article']) ? $info ['article'] = $param ['article'] : false;
            isset($param ['tagid']) ? $info ['tagid'] = $param ['tagid'] : false;
            isset($param ['updatetime']) ? $info ['updatetime'] = $param ['updatetime'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['video']) ? $info['video'] = $param['video'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            $result = $this->dao->updateNewsById($info, $id);
        }
        return $result;
    }

    /**
     * News新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addNews($param) {
        $info = $param;
        return $this->dao->addNews($info);
    }
}
