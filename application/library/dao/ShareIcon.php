<?php
class Dao_ShareIcon extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_share_icon列表
     * @param array 入参
     * @return array
     */
    public function getShareIconList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_share_icon limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_share_icon详情
     * @param int id 
     * @return array
     */
    public function getShareIconDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_share_icon where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_share_icon
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateShareIconById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_share_icon',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_share_icon数据
     * @param array
     * @return int id
     */
    public function addShareIcon(array $info){
        $this->db->insert('hotel_share_icon', $info);
        return $this->db->lastInsertId();
    }
}
