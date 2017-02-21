<?php
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

    public function getGroupDetail (int $id){
        
    }

    public function updateGroupById(array $info){
        
    }

    public function addGroup(array $info){
        
    }
}

