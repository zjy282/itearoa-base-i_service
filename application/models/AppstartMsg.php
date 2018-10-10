<?php

/**
 * Class AppstartMsgModel
 * APP启动消息
 */
class AppstartMsgModel extends \BaseModel {

    const TYPE_HOTEL = 1;

    const TYPE_GROUP = 2;

    const STATUS_ENABLE = 1;

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_AppstartMsg();
    }

    /**
     * 获取AppstartMsg列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppstartMsgList(array $param) {
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['type'] ? $paramList['type'] = intval($param['type']) : false;
        $param['dataid'] ? $paramList['dataid'] = intval($param['dataid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppstartMsgList($paramList);
    }

    /**
     * 获取AppstartMsg数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppstartMsgCount(array $param) {
        $paramList = array();
        isset($param['id']) ? $paramList['id'] = intval($param['id']) : false;
        isset($param['type']) ? $paramList['type'] = intval($param['type']) : false;
        isset($param['dataid']) ? $paramList['dataid'] = intval($param['dataid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getAppstartMsgCount($paramList);
    }

    /**
     * 根据id查询AppstartMsg信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getAppstartMsgDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAppstartMsgDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppstartMsg信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateAppstartMsgById($param, $id) {
        $result = false;
        if ($id) {
            !is_null($param['type']) ? $info['type'] = $param['type'] : false;
            !is_null($param['dataid']) ? $info['dataid'] = $param['dataid'] : false;
            !is_null($param['pic']) ? $info['pic'] = $param['pic'] : false;
            !is_null($param['msg']) ? $info['msg'] = $param['msg'] : false;
            !is_null($param['url']) ? $info['url'] = $param['url'] : false;
            !is_null($param['status']) ? $info['status'] = $param['status'] : false;
            $result = $this->dao->updateAppstartMsgById($info, $id);
        }
        return $result;
    }

    /**
     * AppstartMsg新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addAppstartMsg($param) {
        !is_null($param['type']) ? $info['type'] = $param['type'] : false;
        !is_null($param['dataid']) ? $info['dataid'] = $param['dataid'] : false;
        !is_null($param['pic']) ? $info['pic'] = $param['pic'] : false;
        !is_null($param['msg']) ? $info['msg'] = $param['msg'] : false;
        !is_null($param['url']) ? $info['url'] = $param['url'] : false;
        !is_null($param['status']) ? $info['status'] = $param['status'] : false;
        return $this->dao->addAppstartMsg($info);
    }
}
