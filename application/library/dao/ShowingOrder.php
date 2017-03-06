<?php
class Dao_ShowingOrder extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_showing_order列表
     * @param array 入参
     * @return array
     */
    public function getShowingOrderList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_showing_order limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_showing_order详情
     * @param int id 
     * @return array
     */
    public function getShowingOrderDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_showing_order where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_showing_order
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateShowingOrderById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_showing_order',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_showing_order数据
     * @param array
     * @return int id
     */
    public function addShowingOrder(array $info){
        $this->db->insert('hotel_showing_order', $info);
        return $this->db->lastInsertId();
    }
}
