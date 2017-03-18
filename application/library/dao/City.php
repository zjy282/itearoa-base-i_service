<?php

class Dao_City extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_city列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getCityList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if ($param['id']) {
            if (is_array($param['id'])) {
                $whereSql[] = 'id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'id = ?';
                $whereCase[] = $param['id'];
            }
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from iservice_city {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询iservice_city详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getCityDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from iservice_city where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新iservice_city
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateCityById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('iservice_city', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加iservice_city数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addCity(array $info) {
        $this->db->insert('iservice_city', $info);
        return $this->db->lastInsertId();
    }
}
