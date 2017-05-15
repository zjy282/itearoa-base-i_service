<?php

/**
 * Class ActivityTagModel
 * 活动标签Model
 */
class ActivityTagModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ActivityTag();
    }

    /**
     * 获取ActivityTag列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getActivityTagList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getActivityTagList($paramList);
    }

    /**
     * 获取ActivityTag数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getActivityTagCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getActivityTagCount($paramList);
    }

    /**
     * 根据id查询ActivityTag信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getActivityTagDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getActivityTagDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ActivityTag信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateActivityTagById($param, $id) {
        $result = false;
        if ($id) {
            $info['title_lang1'] = strval($param['title_lang1']);
            $info['title_lang2'] = strval($param['title_lang2']);
            $info['title_lang3'] = strval($param['title_lang3']);
            $result = $this->dao->updateActivityTagById($info, $id);
        }
        return $result;
    }

    /**
     * ActivityTag新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addActivityTag($param) {
        $info['hotelid'] = intval($param['hotelid']);
        $info['title_lang1'] = strval($param['title_lang1']);
        $info['title_lang2'] = strval($param['title_lang2']);
        $info['title_lang3'] = strval($param['title_lang3']);
        return $this->dao->addActivityTag($info);
    }
}
