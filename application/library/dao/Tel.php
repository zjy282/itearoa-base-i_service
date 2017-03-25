<?php

class Dao_Tel extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_tel列表
     * 
     * @param
     *            array 入参
     * @return array
     */
    public function getTelList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_tel {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_tel详情
     * 
     * @param
     *            int id
     * @return array
     */
    public function getTelDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_tel where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_tel
     * 
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateTelById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_tel', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_tel数据
     * 
     * @param
     *            array
     * @return int id
     */
    public function addTel(array $info) {
        $this->db->insert('hotel_tel', $info);
        return $this->db->lastInsertId();
    }
}
