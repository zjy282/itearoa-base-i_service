<?php
class Dao_IserviceFeedback extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询iservice_feedback列表
     * @param array 入参
     * @return array
     */
    public function getIserviceFeedbackList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from iservice_feedback limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询iservice_feedback详情
     * @param int id 
     * @return array
     */
    public function getIserviceFeedbackDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from iservice_feedback where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_feedback
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateIserviceFeedbackById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('iservice_feedback',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_feedback数据
     * @param array
     * @return int id
     */
    public function addIserviceFeedback(array $info){
        $this->db->insert('iservice_feedback', $info);
        return $this->db->lastInsertId();
    }
}
