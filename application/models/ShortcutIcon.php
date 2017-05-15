<?php

/**
 * Class ShortcutIconModel
 * APP快捷入口管理
 */
class ShortcutIconModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShortcutIcon();
    }

    /**
     * 获取ShortcutIcon列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShortcutIconList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['key'] ? $paramList['key'] = trim($param['key']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShortcutIconList($paramList);
    }

    /**
     * 获取ShortcutIcon数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShortcutIconCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['key'] ? $paramList['key'] = trim($param['key']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getShortcutIconCount($paramList);
    }

    /**
     * 根据id查询ShortcutIcon信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShortcutIconDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShortcutIconDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ShortcutIcon信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShortcutIconById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
            isset($param['key']) ? $info['key'] = $param['key'] : false;
            isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
            isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
            isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
            $result = $this->dao->updateShortcutIconById($info, $id);
        }
        return $result;
    }

    /**
     * ShortcutIcon新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addShortcutIcon($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['sort']) ? $info['sort'] = $param['sort'] : false;
        isset($param['key']) ? $info['key'] = $param['key'] : false;
        isset($param['title_lang1']) ? $info['title_lang1'] = $param['title_lang1'] : false;
        isset($param['title_lang2']) ? $info['title_lang2'] = $param['title_lang2'] : false;
        isset($param['title_lang3']) ? $info['title_lang3'] = $param['title_lang3'] : false;
        return $this->dao->addShortcutIcon($info);
    }
}
