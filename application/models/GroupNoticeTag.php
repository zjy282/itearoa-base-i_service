<?php

/**
 * Class GroupNoticeTagModel
 * 新闻标签管理
 */
class GroupNoticeTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_GroupNoticeTag();
    }

    /**
     * 获取GroupNoticeTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNoticeTagList(array $param) {
        $paramList = array();
        isset($param['groupid']) ? $paramList['groupid'] = intval($param['groupid']) : false;
        return $this->dao->getNoticTagList($paramList);
    }

    /**
     * 获取GroupNoticeTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNoticeTagCount(array $param) {
        $paramList = array();
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        return $this->dao->getNoticTagCount($paramList);
    }

    /**
     * 根据id查询GroupNoticeTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getNoticeTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getNoticTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新GroupNoticeTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateNoticeTagById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = $param['title_lang1'];
            $info['title_lang2'] = $param['title_lang2'];
            $info['title_lang3'] = $param['title_lang3'];
            $info['groupid'] = $param['groupid'];
            $result = $this->dao->updateNoticTagById($info, $id);
        }
        return $result;
    }

    /**
     * GroupNoticeTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addNoticeTag($param) {
        $info['title_lang1'] = $param['title_lang1'];
        $info['title_lang2'] = $param['title_lang2'];
        $info['title_lang3'] = $param['title_lang3'];
        $info ['groupid'] = $param ['groupid'];
        return $this->dao->addNoticTag($info);
    }
}
