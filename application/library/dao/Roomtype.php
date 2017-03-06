<?php
class Dao_Roomtype extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_roomtype列表
     * @param array 入参
     * @return array
     */
    public function getRoomtypeList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_roomtype limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_roomtype详情
     * @param int id 
     * @return array
     */
    public function getRoomtypeDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_roomtype where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_roomtype
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateRoomtypeById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_roomtype',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_roomtype数据
     * @param array
     * @return int id
     */
    public function addRoomtype(array $info){
        $this->db->insert('hotel_roomtype', $info);
        return $this->db->lastInsertId();
    }
}
