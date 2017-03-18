<?php

class Dao_HotelList extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_list列表
     * 
     * @param
     *            array 入参
     * @return array
     */
    public function getHotelListList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['groupid'])) {
            $whereSql[] = 'groupid = ?';
            $whereCase[] = $param['groupid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_list {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_list详情
     * 
     * @param
     *            int id
     * @return array
     */
    public function getHotelListDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_list where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_list
     * 
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateHotelListById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_list', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_list数据
     * 
     * @param
     *            array
     * @return int id
     */
    public function addHotelList(array $info) {
        $this->db->insert('hotel_list', $info);
        return $this->db->lastInsertId();
    }
}
