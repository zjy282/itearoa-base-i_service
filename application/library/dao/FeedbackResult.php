<?php
class Dao_FeedbackResult extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_feedback_result列表
     * @param array 入参
     * @return array
     */
    public function getFeedbackResultList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_feedback_result limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_feedback_result详情
     * @param int id 
     * @return array
     */
    public function getFeedbackResultDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_feedback_result where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_feedback_result
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateFeedbackResultById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_feedback_result',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_feedback_result数据
     * @param array
     * @return int id
     */
    public function addFeedbackResult(array $info){
        $this->db->insert('hotel_feedback_result', $info);
        return $this->db->lastInsertId();
    }
}
