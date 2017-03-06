<?php
class Dao_OperateLog extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询iservice_operate_log列表
     * @param array 入参
     * @return array
     */
    public function getOperateLogList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from iservice_operate_log limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询iservice_operate_log详情
     * @param int id 
     * @return array
     */
    public function getOperateLogDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from iservice_operate_log where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_operate_log
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateOperateLogById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('iservice_operate_log',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_operate_log数据
     * @param array
     * @return int id
     */
    public function addOperateLog(array $info){
        $this->db->insert('iservice_operate_log', $info);
        return $this->db->lastInsertId();
    }
}
