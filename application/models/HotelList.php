<?php

class HotelListModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_HotelList();
    }
    
    /**
     * 获取HotelList列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getHotelListList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getHotelListList($paramList);
    }

    /**
     * 根据id查询HotelList信息
     * @param int id 查询的主键
     * @return array
     */
    public function getHotelListDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getHotelListDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新HotelList信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateHotelListById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateHotelListById($info,$id);
        }
        return $result;
    }

    /**
     * HotelList新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addHotelList($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addHotelList($info);
    }
}
