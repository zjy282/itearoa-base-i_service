<?php

/**
 * Class IserviceAdministratorModel
 * 总后台管理员Model
 */
class IserviceAdministratorModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_IserviceAdministrator();
    }

    /**
     * 获取IserviceAdministrator列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getIserviceAdministratorList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['username'] ? $paramList['username'] = $param['username'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getIserviceAdministratorList($paramList);
    }

    /**
     * 获取IserviceAdministrator数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getIserviceAdministratorCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['username'] ? $paramList['username'] = $param['username'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getIserviceAdministratorCount($paramList);
    }

    /**
     * 根据id查询IserviceAdministrator信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getIserviceAdministratorDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getIserviceAdministratorDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新IserviceAdministrator信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateIserviceAdministratorById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['userName']) ? $info['username'] = $param['userName'] : false;
            isset($param['password']) ? $info['password'] = $param['password'] : false;
            isset($param['realName']) ? $info['realname'] = $param['realName'] : false;
            isset($param['remark']) ? $info['remark'] = $param['remark'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $result = $this->dao->updateIserviceAdministratorById($info, $id);
        }
        return $result;
    }

    /**
     * IserviceAdministrator新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addIserviceAdministrator($param) {
        isset($param['userName']) ? $info['username'] = $param['userName'] : false;
        isset($param['password']) ? $info['password'] = $param['password'] : false;
        isset($param['realName']) ? $info['realname'] = $param['realName'] : false;
        isset($param['remark']) ? $info['remark'] = $param['remark'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        isset($param['createAdmin']) ? $info['createadmin'] = $param['createAdmin'] : false;
        $info['createtime'] = $param['createTime'];
        $userInfo = $this->dao->getIserviceAdministratorDetailByUsername($info['username']);
        if ($userInfo) {
            $this->throwException('用户名已经存在', 2);
        }
        return $this->dao->addIserviceAdministrator($info);
    }

    /**
     * 总后台登录
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

        $userInfo = $this->dao->getIserviceAdministratorDetailByUsername($username);
        if ($userInfo['password'] != $password) {
            $this->throwException('用户名或密码错误！', 4);
        }
        if ($userInfo['status'] != 1) {
            $this->throwException('该用户已经被禁用!', 5);
        }

        $updateParam = array();
        $userInfo['lastloginip'] = $updateParam['lastloginip'] = $ip;
        $userInfo['lastlogintime'] = $updateParam['lastlogintime'] = time();
        $this->dao->updateIserviceAdministratorById($updateParam, $userInfo['id']);

        return $userInfo;
    }

    /**
     * 总后台修改密码
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
        $userInfo = $this->dao->getIserviceAdministratorDetail($userid);
        if (empty($userInfo)) {
            $this->throwException('用户不存在', 4);
        }
        if ($userInfo['password'] != $oldpass) {
            $this->throwException('原密码错误！', 5);
        }
        if ($this->dao->updateIserviceAdministratorById(array(
            'password' => $newpass
        ), $userid)
        ) {
            return $userInfo;
        } else {
            $this->throwException('修改失败', 6);
        }
    }
}
