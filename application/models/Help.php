<?php

/**
 * Class HelpModel
 * 集团帮助
 */
class HelpModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Help ();
    }

    /**
     * 获取Help列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHelpList(array $param) {
        isset ($param ['groupid']) ? $paramList ['groupid'] = intval($param ['groupid']) : false;
        $param ['typeid'] ? $paramList ['typeid'] = intval($param ['typeid']) : false;
        $param ['id'] ? $paramList ['id'] = intval($param ['id']) : false;
        $param ['title'] ? $paramList ['title'] = $param ['title'] : false;
        isset ($param ['status']) ? $paramList ['status'] = intval($param ['status']) : false;
        $paramList ['limit'] = $param ['limit'];
        $paramList ['page'] = $param ['page'];
        return $this->dao->getHelpList($paramList);
    }

    /**
     * 获取Help数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getHelpCount(array $param) {
        isset ($param ['groupid']) ? $paramList ['groupid'] = intval($param ['groupid']) : false;
        $param ['typeid'] ? $paramList ['typeid'] = intval($param ['typeid']) : false;
        isset ($param ['status']) ? $paramList ['status'] = intval($param ['status']) : false;
        return $this->dao->getHelpCount($paramList);
    }

    /**
     * 根据id查询Help信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getHelpDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getHelpDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Help信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateHelpById($param, $id) {
        $result = false;
        if ($id) {
            $info = array();
            isset($param ['title_zh']) ? $info ['title_zh'] = $param ['title_zh'] : false;
            isset($param ['title_en']) ? $info ['title_en'] = $param ['title_en'] : false;
            isset($param ['sort']) ? $info ['sort'] = $param ['sort'] : false;
            isset($param ['help_zh']) ? $info ['help_zh'] = $param ['help_zh'] : false;
            isset($param ['help_en']) ? $info ['help_en'] = $param ['help_en'] : false;
            isset($param ['status']) ? $info ['status'] = $param ['status'] : false;
            isset($param ['groupid']) ? $info ['groupid'] = $param ['groupid'] : false;
            isset($param ['typeid']) ? $info ['typeid'] = $param ['typeid'] : false;
            $info['updatetime'] = time();
            $result = $this->dao->updateHelpById($info, $id);
        }
        return $result;
    }

    /**
     * Help新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addHelp($param) {
        $info = array();
        isset($param ['title_zh']) ? $info ['title_zh'] = $param ['title_zh'] : false;
        isset($param ['title_en']) ? $info ['title_en'] = $param ['title_en'] : false;
        isset($param ['sort']) ? $info ['sort'] = $param ['sort'] : false;
        isset($param ['help_zh']) ? $info ['help_zh'] = $param ['help_zh'] : false;
        isset($param ['help_en']) ? $info ['help_en'] = $param ['help_en'] : false;
        isset($param ['status']) ? $info ['status'] = $param ['status'] : false;
        isset($param ['groupid']) ? $info ['groupid'] = $param ['groupid'] : false;
        isset($param ['typeid']) ? $info ['typeid'] = $param ['typeid'] : false;
        $info['createtime'] = time();
        $info['updatetime'] = time();
        return $this->dao->addHelp($info);
    }
}
