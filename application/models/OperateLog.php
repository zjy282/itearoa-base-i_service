<?php

/**
 * Class OperateLogModel
 * 操作日志Model
 */
class OperateLogModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_OperateLog();
    }

    /**
     * 获取OperateLog列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getOperateLogList(array $param) {
        $param['operatorid'] ? $paramList['operatorid'] = $param['operatorid'] : false;
        $param['module'] ? $paramList['module'] = $param['module'] : false;
        isset($param['code']) ? $paramList['code'] = $param['code'] : false;
        $param['admintype'] ? $paramList['admintype'] = $param['admintype'] : false;
        $param['admintypeid'] ? $paramList['admintypeid'] = $param['admintypeid'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getOperateLogList($paramList);
    }

    /**
     * 获取OperateLog数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getOperateLogCount(array $param) {
        $paramList = array();
        $param['operatorid'] ? $paramList['operatorid'] = $param['operatorid'] : false;
        $param['module'] ? $paramList['module'] = $param['module'] : false;
        isset($param['code']) ? $paramList['code'] = $param['code'] : false;
        $param['admintype'] ? $paramList['admintype'] = $param['admintype'] : false;
        $param['admintypeid'] ? $paramList['admintypeid'] = $param['admintypeid'] : false;
        return $this->dao->getOperateLogCount($paramList);
    }

    /**
     * 根据id查询OperateLog信息
     * @param int id 查询的主键
     * @return array
     */
    public function getOperateLogDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getOperateLogDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新OperateLog信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateOperateLogById($param, $id) {
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateOperateLogById($info, $id);
        }
        return $result;
    }

    /**
     * OperateLog新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addOperateLog($param) {
        $info['operatorid'] = intval($param['operatorid']);
        $info['dataid'] = trim($param['dataid']);
        $info['code'] = intval($param['code']);
        $info['msg'] = trim($param['msg']);
        $info['module'] = intval($param['module']);
        $info['action'] = intval($param['action']);
        $info['ip'] = Util_Tools::ipton($param['ip']);
        $info['miscinfo'] = trim($param['miscinfo']);
        $info['admintype'] = intval($param['admintype']);
        $info['admintypeid'] = intval($param['admintypeid']);
        $info['addtime'] = time();
        return $this->dao->addOperateLog($info);
    }
}
