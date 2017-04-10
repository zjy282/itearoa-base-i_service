<?php

/**
 * 集团管理员类
 */
class AdministratorModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Administrator();
    }

    /**
     * 获取Administrator列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getAdministratorList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        $param['username'] ? $paramList['username'] = $param['username'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAdministratorList($paramList);
    }

    /**
     * 获取Administrator数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAdministratorCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        $param['username'] ? $paramList['username'] = $param['username'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getAdministratorCount($paramList);
    }

    /**
     * 根据id查询Administrator信息
     * @param int id 查询的主键
     * @return array
     */
    public function getAdministratorDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAdministratorDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Administrator信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateAdministratorById($param, $id) {
        $result = false;

        if ($id) {
            isset($param['id']) ? $info['id'] = $param['id'] : false;
            isset($param['userName']) ? $info['username'] = $param['userName'] : false;
            isset($param['realName']) ? $info['realname'] = $param['realName'] : false;
            isset($param['remark']) ? $info['remark'] = $param['remark'] : false;
            isset($param['status']) ? $info['status'] = intval($param['status']) : false;
            isset($param['lastLoginTime']) ? $info['lastlogintime'] = $param['lastLoginTime'] : false;
            isset($param['lastLoginIp']) ? $info['lastloginip'] = $param['lastLoginIp'] : false;
            isset($param['createTime']) ? $info['createtime'] = $param['createTime'] : false;
            isset($param['createAdmin']) ? $info['createadmin'] = $param['createAdmin'] : false;
            isset($param['groupId']) ? $info['groupid'] = $param['groupId'] : false;
            $result = $this->dao->updateAdministratorById($info, $id);
        }
        return $result;
    }

    /**
     * Administrator新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addAdministrator($param) {
        isset($param['id']) ? $info['id'] = $param['id'] : false;
        isset($param['userName']) ? $info['username'] = $param['userName'] : false;
        isset($param['realName']) ? $info['realname'] = $param['realName'] : false;
        isset($param['remark']) ? $info['remark'] = $param['remark'] : false;
        isset($param['status']) ? $info['status'] = intval($param['status']) : false;
        isset($param['lastLoginTime']) ? $info['lastlogintime'] = $param['lastLoginTime'] : false;
        isset($param['lastLoginIp']) ? $info['lastloginip'] = $param['lastLoginIp'] : false;
        isset($param['createTime']) ? $info['createtime'] = $param['createTime'] : false;
        isset($param['createAdmin']) ? $info['createadmin'] = $param['createAdmin'] : false;
        isset($param['groupId']) ? $info['groupid'] = $param['groupId'] : false;
        return $this->dao->addAdministrator($info);
    }
}
