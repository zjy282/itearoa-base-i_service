<?php
class Dao_RoomtypePic extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_roomtype_pic列表
     * @param array 入参
     * @return array
     */
    public function getRoomtypePicList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_roomtype_pic limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_roomtype_pic详情
     * @param int id 
     * @return array
     */
    public function getRoomtypePicDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_roomtype_pic where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_roomtype_pic
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateRoomtypePicById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_roomtype_pic',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_roomtype_pic数据
     * @param array
     * @return int id
     */
    public function addRoomtypePic(array $info){
        $this->db->insert('hotel_roomtype_pic', $info);
        return $this->db->lastInsertId();
    }
}
