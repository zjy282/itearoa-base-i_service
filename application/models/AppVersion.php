<?php

class AppVersionModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_AppVersion();
    }
    
    /**
     * 获取AppVersion列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getAppVersionList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppVersionList($paramList);
    }

    /**
     * 根据id查询AppVersion信息
     * @param int id 查询的主键
     * @return array
     */
    public function getAppVersionDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getAppVersionDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppVersion信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateAppVersionById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateAppVersionById($info,$id);
        }
        return $result;
    }

    /**
     * AppVersion新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addAppVersion($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addAppVersion($info);
    }
}
