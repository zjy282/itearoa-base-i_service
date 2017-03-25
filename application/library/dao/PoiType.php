<?php

class Dao_PoiType extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_poi_type列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPoiTypeList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_poi_type {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_poi_type详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getPoiTypeDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_poi_type where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_poi_type
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updatePoiTypeById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_poi_type', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_poi_type数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addPoiType(array $info) {
        $this->db->insert('hotel_poi_type', $info);
        return $this->db->lastInsertId();
    }
}
