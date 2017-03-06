<?php
class Dao_Traffic extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_traffic列表
     * @param array 入参
     * @return array
     */
    public function getTrafficList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_traffic limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_traffic详情
     * @param int id 
     * @return array
     */
    public function getTrafficDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_traffic where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_traffic
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateTrafficById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_traffic',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_traffic数据
     * @param array
     * @return int id
     */
    public function addTraffic(array $info){
        $this->db->insert('hotel_traffic', $info);
        return $this->db->lastInsertId();
    }
}
