<?php

/**
 * Class AppstartPicModel
 * APP启动广告图
 */
class AppstartPicModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_AppstartPic();
    }

    /**
     * 获取AppstartPic列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppstartPicList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppstartPicList($paramList);
    }

    /**
     * 获取AppstartPic数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppstartPicCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getAppstartPicCount($paramList);
    }

    /**
     * 根据id查询AppstartPic信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getAppstartPicDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAppstartPicDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppstartPic信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateAppstartPicById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            !is_null($param['pic']) ? $info['pic'] = $param['pic'] : false;
            !is_null($param['status']) ? $info['status'] = $param['status'] : false;
            !is_null($param['link']) ? $info['link'] = $param['link'] : false;
            $result = $this->dao->updateAppstartPicById($info, $id);
        }
        return $result;
    }

    /**
     * AppstartPic新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addAppstartPic($param) {
        !is_null($param['pic']) ? $info['pic'] = $param['pic'] : false;
        !is_null($param['status']) ? $info['status'] = $param['status'] : false;
        !is_null($param['link']) ? $info['link'] = $param['link'] : false;
        !is_null($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        return $this->dao->addAppstartPic($info);
    }
}
