<?php

class Dao_Activity extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_activity列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getActivityList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $paramSql = $this->handlerActivityListParams($param);
        $sql = "select * from hotel_activity {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_news数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getActivityCount(array $param): int {
        $paramSql = $this->handlerActivityListParams($param);
        $sql = "select count(1) as count from hotel_activity {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    private function handlerActivityListParams($param) {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['tagid'])) {
            $whereSql[] = 'tagid = ?';
            $whereCase[] = $param['tagid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_activity详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getActivityDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_activity where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_activity
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateActivityById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_activity', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_activity数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addActivity(array $info) {
        $this->db->insert('hotel_activity', $info);
        return $this->db->lastInsertId();
    }
}
