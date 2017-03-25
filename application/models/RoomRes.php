<?php

class RoomResModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_RoomRes();
    }
    
    /**
     * 获取RoomRes列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getRoomResList(array $param){
        isset($param['id']) ? $paramList['id'] = $param['id'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRoomResList($paramList);
    }

    /**
     * 根据id查询RoomRes信息
     * @param int id 查询的主键
     * @return array
     */
    public function getRoomResDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getRoomResDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新RoomRes信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateRoomResById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateRoomResById($info,$id);
        }
        return $result;
    }

    /**
     * RoomRes新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addRoomRes($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addRoomRes($info);
    }
}
