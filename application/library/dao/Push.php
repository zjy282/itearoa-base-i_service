<?php
class Dao_Push extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询iservice_push列表
     * @param array 入参
     * @return array
     */
    public function getPushList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from iservice_push limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询iservice_push详情
     * @param int id 
     * @return array
     */
    public function getPushDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from iservice_push where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_push
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updatePushById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('iservice_push',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_push数据
     * @param array
     * @return int id
     */
    public function addPush(array $info){
        $this->db->insert('iservice_push', $info);
        return $this->db->lastInsertId();
    }
}
