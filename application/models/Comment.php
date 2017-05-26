<?php

/**
 * Class CommentModel
 * 评论管理
 */
class CommentModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Comment();
    }

    /**
     * 获取Comment列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getCommentList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['datatype'] ? $paramList['datatype'] = intval($param['datatype']) : false;
        $param['dataid'] ? $paramList['dataid'] = intval($param['dataid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        $param['roomno'] ? $paramList['roomno'] = trim($param['roomno']) : false;
        $param['status'] ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getCommentList($paramList);
    }

    /**
     * 获取Comment数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getCommentCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['datatype'] ? $paramList['datatype'] = intval($param['datatype']) : false;
        $param['dataid'] ? $paramList['dataid'] = intval($param['dataid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        $param['roomno'] ? $paramList['roomno'] = trim($param['roomno']) : false;
        $param['status'] ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getCommentCount($paramList);
    }

    /**
     * 根据id查询Comment信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getCommentDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getCommentDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Comment信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateCommentById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $result = $this->dao->updateCommentById($info, $id);
        }
        return $result;
    }

    /**
     * Comment新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addComment($param) {
        isset($param['userid']) ? $info['userid'] = $param['userid'] : false;
        isset($param['roomno']) ? $info['roomno'] = $param['roomno'] : false;
        isset($param['fullname']) ? $info['fullname'] = $param['fullname'] : false;
        isset($param['value']) ? $info['value'] = $param['value'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['ip']) ? $info['ip'] = $param['ip'] : false;
        isset($param['datatype']) ? $info['datatype'] = $param['datatype'] : false;
        isset($param['dataid']) ? $info['dataid'] = $param['dataid'] : false;
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        $info['createtime'] = time();
        return $this->dao->addComment($info);
    }
}
