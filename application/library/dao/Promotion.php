<?php
class Dao_Promotion extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_promotion列表
     * @param array 入参
     * @return array
     */
    public function getPromotionList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_promotion limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_promotion详情
     * @param int id 
     * @return array
     */
    public function getPromotionDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_promotion where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_promotion
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updatePromotionById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_promotion',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_promotion数据
     * @param array
     * @return int id
     */
    public function addPromotion(array $info){
        $this->db->insert('hotel_promotion', $info);
        return $this->db->lastInsertId();
    }
}