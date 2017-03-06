<?php
class Dao_RoomResPic extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_room_res_pic列表
     * @param array 入参
     * @return array
     */
    public function getRoomResPicList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_room_res_pic limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_room_res_pic详情
     * @param int id 
     * @return array
     */
    public function getRoomResPicDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_room_res_pic where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_room_res_pic
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateRoomResPicById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_room_res_pic',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_room_res_pic数据
     * @param array
     * @return int id
     */
    public function addRoomResPic(array $info){
        $this->db->insert('hotel_room_res_pic', $info);
        return $this->db->lastInsertId();
    }
}
