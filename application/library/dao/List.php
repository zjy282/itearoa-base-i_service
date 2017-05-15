<?php
/**
 * 集团管理数据层
 */
class Dao_List extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询group_list列表
     * @param array 入参
     * @return array
     */
    public function getListList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from group_list limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询group_list详情
     * @param int id 
     * @return array
     */
    public function getListDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from group_list where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新group_list
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateListById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('group_list',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加group_list数据
     * @param array
     * @return int id
     */
    public function addList(array $info){
        $this->db->insert('group_list', $info);
        return $this->db->lastInsertId();
    }
}
