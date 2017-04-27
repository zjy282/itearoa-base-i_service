<?php

class NewsTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_NewsTag();
    }

    /**
     * 获取NewsTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getNewsTagList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getNewsTagList($paramList);
    }

    /**
     * 根据id查询NewsTag信息
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
     * 根据id更新NewsTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateNewsTagById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateNewsTagById($info, $id);
        }
        return $result;
    }

    /**
     * NewsTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addNewsTag($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addNewsTag($info);
    }
}
