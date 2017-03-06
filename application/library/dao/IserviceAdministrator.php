<?php
class Dao_IserviceAdministrator extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询iservice_administrator列表
     * @param array 入参
     * @return array
     */
    public function getIserviceAdministratorList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from iservice_administrator limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询iservice_administrator详情
     * @param int id 
     * @return array
     */
    public function getIserviceAdministratorDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from iservice_administrator where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_administrator
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateIserviceAdministratorById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('iservice_administrator',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_administrator数据
     * @param array
     * @return int id
     */
    public function addIserviceAdministrator(array $info){
        $this->db->insert('iservice_administrator', $info);
        return $this->db->lastInsertId();
    }
}
