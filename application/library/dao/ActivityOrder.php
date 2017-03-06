<?php
class Dao_ActivityOrder extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_activity_order列表
     * @param array 入参
     * @return array
     */
    public function getActivityOrderList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_activity_order limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_activity_order详情
     * @param int id 
     * @return array
     */
    public function getActivityOrderDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_activity_order where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_activity_order
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateActivityOrderById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_activity_order',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_activity_order数据
     * @param array
     * @return int id
     */
    public function addActivityOrder(array $info){
        $this->db->insert('hotel_activity_order', $info);
        return $this->db->lastInsertId();
    }
}
