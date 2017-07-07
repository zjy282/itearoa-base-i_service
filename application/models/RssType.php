<?php

/**
 * Class RssTypeModel
 * RSS类型管理
 */
class RssTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_RssType();
    }

    /**
     * 获取RssType列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRssTypeList(array $param) {
        isset($param['limit']) ? $paramList['limit'] = $param['limit'] : false;
        $paramList['page'] = $param['page'];
        return $this->dao->getRssTypeList($paramList);
    }

    /**
     * 获取RssType数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getRssTypeCount(array $param) {
        $paramList = array();
        return $this->dao->getRssTypeCount($paramList);
    }

    /**
     * 根据id查询RssType信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getRssTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getRssTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新RssType信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateRssTypeById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['title']) ? $info['title'] = $param['title'] : false;
            isset($param['title_en']) ? $info['title_en'] = $param['title_en'] : false;
            $result = $this->dao->updateRssTypeById($info, $id);
        }
        return $result;
    }

    /**
     * RssType新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addRssType($param) {
        isset($param['title']) ? $info['title'] = $param['title'] : false;
        isset($param['title_en']) ? $info['title_en'] = $param['title_en'] : false;
        return $this->dao->addRssType($info);
    }
}
