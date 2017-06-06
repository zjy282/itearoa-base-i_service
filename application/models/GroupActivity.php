<?php

/**
 * Class GroupActivityModel
 * 活动管理Model
 */
class GroupActivityModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_GroupActivity();
    }

    /**
     * 获取GroupActivity列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getActivityList(array $param) {
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        $param['tagid'] ? $paramList['tagid'] = intval($param['tagid']) : false;
        $param['title'] ? $paramList['title'] = $param['title'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getActivityList($paramList);
    }

    /**
     * 获取Activity数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getActivityCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        $param['tagid'] ? $paramList['tagid'] = intval($param['tagid']) : false;
        $param['title'] ? $paramList['title'] = intval($param['title']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getActivityCount($paramList);
    }

    /**
     * 根据id查询Activity信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getActivityDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getActivityDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Activity信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateActivityById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
            isset($param['tagid']) ? $info['tagid'] = $param['tagid'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
            isset($param['fromdate']) ? $info['fromdate'] = $param['fromdate'] : false;
            isset($param['todate']) ? $info['todate'] = $param['todate'] : false;
            isset($param['ordercount']) ? $info['ordercount'] = $param['ordercount'] : false;
            isset($param['title']) ? $info['title'] = $param['title'] : false;
            isset($param['article']) ? $info['article'] = $param['article'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['video']) ? $info['video'] = $param['video'] : false;
            $info['updatetime'] = time();
            $result = $this->dao->updateActivityById($info, $id);
        }
        return $result;
    }

    /**
     * Activity新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addActivity($param) {
        isset($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
        isset($param['tagid']) ? $info['tagid'] = $param['tagid'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['pic']) ? $info['pic'] = $param['pic'] : false;
        isset($param['fromdate']) ? $info['fromdate'] = $param['fromdate'] : false;
        isset($param['todate']) ? $info['todate'] = $param['todate'] : false;
        isset($param['ordercount']) ? $info['ordercount'] = $param['ordercount'] : false;
        isset($param['title']) ? $info['title'] = $param['title'] : false;
        isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
        isset($param['video']) ? $info['video'] = $param['video'] : false;
        $info['createtime'] = time();
        $info['updatetime'] = $info['createtime'];
        return $this->dao->addActivity($info);
    }
}
