<?php

class ActivityOrderModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_ActivityOrder();
    }
    
    /**
     * 获取ActivityOrder列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getActivityOrderList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getActivityOrderList($paramList);
    }

    /**
     * 根据id查询ActivityOrder信息
     * @param int id 查询的主键
     * @return array
     */
    public function getActivityOrderDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getActivityOrderDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ActivityOrder信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateActivityOrderById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateActivityOrderById($info,$id);
        }
        return $result;
    }

    /**
     * ActivityOrder新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addActivityOrder($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addActivityOrder($info);
    }
}
