<?php

class RoomModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_Room();
    }
    
    /**
     * 获取Room列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getRoomList(array $param){
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getRoomList($paramList);
    }

    /**
     * 根据id查询Room信息
     * @param int id 查询的主键
     * @return array
     */
    public function getRoomDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getRoomDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Room信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateRoomById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateRoomById($info,$id);
        }
        return $result;
    }

    /**
     * Room新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addRoom($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addRoom($info);
    }
}
