<?php

class RoomResPicModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_RoomResPic();
    }
    
    /**
     * 获取RoomResPic列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getRoomResPicList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRoomResPicList($paramList);
    }

    /**
     * 根据id查询RoomResPic信息
     * @param int id 查询的主键
     * @return array
     */
    public function getRoomResPicDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getRoomResPicDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新RoomResPic信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateRoomResPicById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateRoomResPicById($info,$id);
        }
        return $result;
    }

    /**
     * RoomResPic新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addRoomResPic($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addRoomResPic($info);
    }
}
