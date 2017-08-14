<?php

/**
 * Class HelpTypeModel
 * 帮助类别管理
 */
class HelpTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_HelpType();
    }

    /**
     * 获取HelpType列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHelpTypeList(array $param) {
        isset($param['groupid']) ? $paramList['groupid'] = intval($param['groupid']) : false;
        isset($param['id']) ? $paramList['id'] = $param['id'] : false;
        return $this->dao->getHelpTypeList($paramList);
    }

    /**
     * 获取HelpType数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHelpTypeCount(array $param) {
        $paramList = array();
        $param['groupid'] ? $paramList['groupid'] = intval($param['groupid']) : false;
        isset($param['id']) ? $paramList['id'] = $param['id'] : false;
        return $this->dao->getHelpTypeCount($paramList);
    }

    /**
     * 根据id查询HelpType信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getHelpTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getHelpTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新HelpType信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateHelpTypeById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_zh'] = $param['title_zh'];
            $info['title_en'] = $param['title_en'];
            $info['sort'] = $param['sort'];
            $result = $this->dao->updateHelpTypeById($info, $id);
        }
        return $result;
    }

    /**
     * HelpType新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addHelpType($param) {
        $info ['title_zh'] = $param ['title_zh'];
        $info ['title_en'] = $param ['title_en'];
        $info ['sort'] = $param ['sort'];
        $info ['groupid'] = $param ['groupid'];
        return $this->dao->addHelpType($info);
    }
}
