<?php

class PromotionTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_PromotionTag();
    }

    /**
     * 获取PromotionTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPromotionTagList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getPromotionTagList($paramList);
    }

    /**
     * 根据id查询PromotionTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPromotionTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPromotionTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新PromotionTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePromotionTagById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updatePromotionTagById($info, $id);
        }
        return $result;
    }

    /**
     * PromotionTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPromotionTag($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addPromotionTag($info);
    }
}
