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
            isset($param['password']) ? $info['password'] = $param['password'] : false;
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
        isset($param['password']) ? $info['password'] = $param['password'] : false;
        isset($param['remark']) ? $info['remark'] = $param['remark'] : false;
        isset($param['status']) ? $info['status'] = intval($param['status']) : false;
        isset($param['lastLoginTime']) ? $info['lastlogintime'] = $param['lastLoginTime'] : false;
        isset($param['lastLoginIp']) ? $info['lastloginip'] = $param['lastLoginIp'] : false;
        isset($param['createTime']) ? $info['createtime'] = $param['createTime'] : false;
        isset($param['createAdmin']) ? $info['createadmin'] = $param['createAdmin'] : false;
        isset($param['groupId']) ? $info['groupid'] = $param['groupId'] : false;
        $userInfo = $this->dao->getAdministratorDetailByUsername($info['username']);
        if ($userInfo) {
            $this->throwException('用户名已经存在', 2);
        }
        return $this->dao->addAdministrator($info);
    }

    /**
     * 集团后台登录
     * @param $param
     * @return array
     */
    public function login($param) {
        $username = trim($param['username']);
        $password = md5(trim($param['password']));
        $ip = Util_Tools::ipton($param['ip'] ? $param['ip'] : Util_Http::getIP());

        if (!$username || !$password) {
            $this->throwException('用户名或密码不能为空！', 3);
        }

        $userInfo = $this->dao->getAdministratorDetailByUsername($username);
        if ($userInfo['password'] != $password) {
            $this->throwException('用户名或密码错误！', 4);
        }
        if ($userInfo['status'] != 1) {
            $this->throwException('该用户已经被禁用!', 5);
        }

        $updateParam = array();
        $userInfo['lastloginip'] = $updateParam['lastloginip'] = $ip;
        $userInfo['lastlogintime'] = $updateParam['lastlogintime'] = time();
        $this->dao->updateAdministratorById($updateParam, $userInfo['id']);

        return $userInfo;
    }

    /**
     * 集团后台修改密码
     * @param $param
     * @return array
     */
    public function changePass($param) {
        $userid = intval($param['userid']);
        $oldpass = trim($param['oldpass']);
        $newpass = trim($param['newpass']);

        if (!$userid || !$oldpass || !$newpass) {
            $this->throwException('参数错误！', 3);
        }
        $userInfo = $this->dao->getAdministratorDetail($userid);
        if (empty($userInfo)) {
            $this->throwException('用户不存在', 4);
        }
        if ($userInfo['password'] != $oldpass) {
            $this->throwException('原密码错误！', 5);
        }
        if ($this->dao->updateAdministratorById(array(
            'password' => $newpass
        ), $userid)
        ) {
            return $userInfo;
        } else {
            $this->throwException('修改失败', 6);
        }
    }
}
