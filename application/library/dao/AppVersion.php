<?php
class Dao_AppVersion extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询iservice_app_version列表
     * @param array 入参
     * @return array
     */
    public function getAppVersionList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from iservice_app_version limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询iservice_app_version详情
     * @param int id 
     * @return array
     */
    public function getAppVersionDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from iservice_app_version where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_app_version
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateAppVersionById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('iservice_app_version',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_app_version数据
     * @param array
     * @return int id
     */
    public function addAppVersion(array $info){
        $this->db->insert('iservice_app_version', $info);
        return $this->db->lastInsertId();
    }
}
