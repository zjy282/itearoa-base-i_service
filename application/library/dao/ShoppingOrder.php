<?php
class Dao_ShoppingOrder extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_shopping_order列表
     * @param array 入参
     * @return array
     */
    public function getShoppingOrderList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_shopping_order limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_shopping_order详情
     * @param int id 
     * @return array
     */
    public function getShoppingOrderDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_shopping_order where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_shopping_order
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateShoppingOrderById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_shopping_order',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_shopping_order数据
     * @param array
     * @return int id
     */
    public function addShoppingOrder(array $info){
        $this->db->insert('hotel_shopping_order', $info);
        return $this->db->lastInsertId();
    }
}
