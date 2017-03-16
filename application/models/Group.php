<?php

class GroupModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_Group();
    }
    
    /**
     * 获取Group列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getGroupList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getGroupList($paramList);
    }

    /**
     * 根据id查询Group信息
     * @param int id 查询的主键
     * @return array
     */
    public function getGroupDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getGroupDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Group信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateGroupById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            isset($param['name']) ?$info['name'] = $param['name'] : false;
            isset($param['enName']) ?$info['enname'] = $param['enName'] : false;
            isset($param['portUrl']) ?$info['port_url'] = $param['portUrl'] : false;
            $result = $this->dao->updateGroupById($info,$id);
        }
        return $result;
    }

    /**
     * Group新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addGroup($param){
        //自行添加要添加的字段,以下是age字段是样例
        isset($param['name']) ?$info['name'] = $param['name'] : false;
        isset($param['enName']) ?$info['enname'] = $param['enName'] : false;
        isset($param['portUrl']) ?$info['port_url'] = $param['portUrl'] : false;
        return $this->dao->addGroup($info);
    }
}
