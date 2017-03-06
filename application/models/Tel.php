<?php

class TelModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_Tel();
    }
    
    /**
     * 获取Tel列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getTelList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getTelList($paramList);
    }

    /**
     * 根据id查询Tel信息
     * @param int id 查询的主键
     * @return array
     */
    public function getTelDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getTelDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Tel信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateTelById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateTelById($info,$id);
        }
        return $result;
    }

    /**
     * Tel新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addTel($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addTel($info);
    }
}
