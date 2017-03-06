<?php
class Dao_User extends Dao_Base{
    
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * 查询hotel_user列表
     * @param array 入参
     * @return array
     */
    public function getUserList(array $param):array {
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);
        $sql = "select * from hotel_user limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result)?$result:array();
    }

    /**
     * 根据id查询hotel_user详情
     * @param int id 
     * @return array
     */
    public function getUserDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from hotel_user where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_user
     * @param array 需要更新的数据
     * @param int id 
     * @return array
     */
    public function updateUserById(array $info,int $id){
        $result = false;

        if ($id){
            $result = $this->db->update('hotel_user',$info,$id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_user数据
     * @param array
     * @return int id
     */
    public function addUser(array $info){
        $this->db->insert('hotel_user', $info);
        return $this->db->lastInsertId();
    }
}
