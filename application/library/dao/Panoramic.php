<?php

class Dao_Panoramic extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_panoramic列表
     * 
     * @param
     *            array 入参
     * @return array
     */
    public function getPanoramicList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_panoramic {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_Panoramic详情
     * 
     * @param
     *            int id
     * @return array
     */
    public function getPanoramicDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_Panoramic where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_panoramic
     * 
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updatePanoramicById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_panoramic', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_panoramic数据
     * 
     * @param
     *            array
     * @return int id
     */
    public function addPanoramic(array $info) {
        $this->db->insert('hotel_panoramic', $info);
        return $this->db->lastInsertId();
    }
}
