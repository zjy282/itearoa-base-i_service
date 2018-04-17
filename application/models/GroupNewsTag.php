<?php

/**
 * Class GroupNewsTagModel
 * 新闻标签管理
 */
class GroupNewsTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_GroupNewsTag();
    }

    /**
     * 获取GroupNewsTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsTagList(array $param) {
        isset($param['groupid']) ? $paramList['groupid'] = intval($param['groupid']) : false;
        return $this->dao->getNewsTagList($paramList);
    }

    /**
     * 获取GroupNewsTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsTagCount(array $param) {
        $paramList = array();
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        return $this->dao->getNewsTagCount($paramList);
    }

    /**
     * 根据id查询GroupNewsTag信息
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
     * 根据id更新GroupNewsTag信息
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
            $info['groupid'] = $param['groupid'];
            $result = $this->dao->updateNewsTagById($info, $id);
        }
        return $result;
    }

    /**
     * GroupNewsTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addNewsTag($param) {
        $info['title_lang1'] = $param['title_lang1'];
        $info['title_lang2'] = $param['title_lang2'];
        $info ['groupid'] = $param ['groupid'];
        return $this->dao->addNewsTag($info);
    }
}
