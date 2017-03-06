<?php
class Dao_Activity extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_activity列表
     * @param array 入参
     * @return array
     */
    public function getActivityList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_activity limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_activity详情
     * @param int id 
     * @return array
     */
    public function getActivityDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_activity where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_activity
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateActivityById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_activity',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_activity数据
     * @param array
     * @return int id
     */
    public function addActivity(array $info){
        $this->db->insert('hotel_activity', $info);
        return $this->db->lastInsertId();
    }
}
