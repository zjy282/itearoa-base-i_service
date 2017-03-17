<?php
/**
 * 集团管理员DAO类
 */
class Dao_Administrator extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询group_administrator列表
     * @param array 入参
     * @return array
     */
    public function getAdministratorList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from group_administrator limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询group_administrator详情
     * @param int id 
     * @return array
     */
    public function getAdministratorDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from group_administrator where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新group_administrator
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateAdministratorById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('group_administrator',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加group_administrator数据
     * @param array
     * @return int id
     */
    public function addAdministrator(array $info){
        $this->db->insert('group_administrator', $info);
        return $this->db->lastInsertId();
    }
}
