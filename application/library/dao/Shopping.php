<?php
class Dao_Shopping extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_shopping列表
     * @param array 入参
     * @return array
     */
    public function getShoppingList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_shopping limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_shopping详情
     * @param int id 
     * @return array
     */
    public function getShoppingDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_shopping where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_shopping
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateShoppingById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_shopping',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_shopping数据
     * @param array
     * @return int id
     */
    public function addShopping(array $info){
        $this->db->insert('hotel_shopping', $info);
        return $this->db->lastInsertId();
    }
}
