<?php
class Dao_Room extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_room列表
     * @param array 入参
     * @return array
     */
    public function getRoomList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_room limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_room详情
     * @param int id 
     * @return array
     */
    public function getRoomDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_room where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_room
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateRoomById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_room',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_room数据
     * @param array
     * @return int id
     */
    public function addRoom(array $info){
        $this->db->insert('hotel_room', $info);
        return $this->db->lastInsertId();
    }
}
