<?php

/**
 * 物业管理数据层
 */
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

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_list {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_list数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getHotelListCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_list {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerListParams($param) {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['id'])) {
            if (is_array($param['id']) && count($param['id']) > 0) {
                $whereSql[] = 'id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'id = ?';
                $whereCase[] = $param['id'];
            }
        }
        if (isset($param['groupid'])) {
            $whereSql[] = 'groupid = ?';
            $whereCase[] = $param['groupid'];
        }
        if (isset($param['propertyinterfid'])) {
            $whereSql[] = 'propertyinterfid = ?';
            $whereCase[] = $param['propertyinterfid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['name'])) {
            $whereSql[] = '(name_lang1 = ? or name_lang2 = ? or name_lang3 = ?)';
            $whereCase[] = $param['name'];
            $whereCase[] = $param['name'];
            $whereCase[] = $param['name'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
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
        return is_array($result) ? $result : array();
    }

    /**
     * 根据propertyinterfid查询物业详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getHotelListDetailByPropertyinterfId(int $propertyinterfId): array {
        $result = array();

        if ($propertyinterfId) {
            $sql = "select * from hotel_list where propertyinterfid = ?";
            $result = $this->db->fetchAssoc($sql, array(
                $propertyinterfId
            ));
        }
        return is_array($result) ? $result : array();
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
            $result = $this->db->update('hotel_list', $info, array('id' => $id));
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
