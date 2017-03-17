<?php
/**
 * 集团信息DAO类
 */
class Dao_Group extends Dao_Base {

    public function __construct(){
        parent::__construct();
    }

    public function getGroupList(array $param):array{
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from group_list limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    public function getGroupDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from group_list where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    public function updateGroupById(array $info,int $id){
        $result = false;
        if ($id){
            $result = $this->db->update('group_list',$info,array('id' => $id));
        }

        return $result;
    }

    public function addGroup(array $info){
        $this->db->insert('group_list', $info);
        return $this->db->lastInsertId();
    }
}

