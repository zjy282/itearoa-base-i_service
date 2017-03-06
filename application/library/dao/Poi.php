<?php
class Dao_Poi extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_poi列表
     * @param array 入参
     * @return array
     */
    public function getPoiList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_poi limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_poi详情
     * @param int id 
     * @return array
     */
    public function getPoiDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_poi where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_poi
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updatePoiById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_poi',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_poi数据
     * @param array
     * @return int id
     */
    public function addPoi(array $info){
        $this->db->insert('hotel_poi', $info);
        return $this->db->lastInsertId();
    }
}
