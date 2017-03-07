<?php
class Dao_Facilities extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_facilities列表
     * @param array 入参
     * @return array
     */
    public function getFacilitiesList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_facilities limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_facilities详情
     * @param int id 
     * @return array
     */
    public function getFacilitiesDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_facilities where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_facilities
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateFacilitiesById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_facilities',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_facilities数据
     * @param array
     * @return int id
     */
    public function addFacilities(array $info){
        $this->db->insert('hotel_facilities', $info);
        return $this->db->lastInsertId();
    }
}