<?php

/**
 * Class AppImgModel
 * 启动图管理Model
 */
class AppImgModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_AppImg();
    }

    /**
     * 获取AppImg列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppImgList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppImgList($paramList);
    }

    /**
     * 获取AppImg数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppImgCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        return $this->dao->getAppImgCount($paramList);
    }

    /**
     * 根据id查询AppImg信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getAppImgDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAppImgDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppImg信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateAppImgById($param, $id) {
        $result = false;
        if ($id) {
            !is_null($param['pickey']) ? $info['pickey'] = $param['pickey'] : false;
            !is_null($param['status']) ? $info['status'] = $param['status'] : false;
            !is_null($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
            $result = $this->dao->updateAppImgById($info, $id);
        }
        return $result;
    }

    /**
     * AppImg新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addAppImg($param) {
        !is_null($param['pickey']) ? $info['pickey'] = $param['pickey'] : false;
        !is_null($param['status']) ? $info['status'] = $param['status'] : false;
        !is_null($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        $info['createtime'] = time();
        return $this->dao->addAppImg($info);
    }

    /**
     * 获取最新可用的启动图
     *
     * @return array
     */
    public function getAvailableAppImg() {
        $result = $this->dao->getAvailableAppImg();
        return $result ? $result : array();
    }
}
