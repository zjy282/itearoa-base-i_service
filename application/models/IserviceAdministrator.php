<?php

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
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getIserviceAdministratorList($paramList);
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
        $info['createtime'] = $param['createTime'];
        return $this->dao->addIserviceAdministrator($info);
    }

    public function login($param) {
        $username = trim($param['username']);
        $password = trim($param['password']);
        
        if (! $username || ! $password) {
            $this->throwException('用户名或密码不能为空！', 3);
        }
        
        $userInfo = $this->dao->getIserviceAdministratorDetailByUsername($username);
        if ($userInfo['password'] != $password) {
            $this->throwException('用户名或密码错误！', 4);
        }
        if ($userInfo['status'] != 1) {
            $this->throwException('该用户已经被禁用!', 5);
        }
        return $userInfo;
    }
}
