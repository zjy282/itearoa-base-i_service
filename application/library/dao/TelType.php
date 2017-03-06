<?php
class Dao_TelType extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_tel_type列表
     * @param array 入参
     * @return array
     */
    public function getTelTypeList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_tel_type limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_tel_type详情
     * @param int id 
     * @return array
     */
    public function getTelTypeDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_tel_type where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_tel_type
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateTelTypeById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_tel_type',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_tel_type数据
     * @param array
     * @return int id
     */
    public function addTelType(array $info){
        $this->db->insert('hotel_tel_type', $info);
        return $this->db->lastInsertId();
    }
}
