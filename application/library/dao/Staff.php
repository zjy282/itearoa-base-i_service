<?php

/**
 * 员工管理数据层
 */
class Dao_Staff extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_staff列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getStaffList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $whereSql = array();
        $whereCase = array();
        if (isset($param['id'])) {
            if (is_array($param['id'])) {
                $whereSql[] = 'id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'id = ?';
                $whereCase[] = $param['id'];
            }
        }
        if (isset($param['staffid'])) {
            if (is_array($param['staffid'])) {
                $whereSql[] = 'staffid in (' . implode(',', $param['staffid']) . ')';
            } else {
                $whereSql[] = 'staffid = ?';
                $whereCase[] = $param['staffid'];
            }
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';

        $sql = "select * from hotel_staff {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_staff详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getStaffDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_staff where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据staffId查询hotel_staff详情
     *
     * @param
     *            string staffId
     * @return array
     */
    public function getStaffDetailByStaffId($staffId) {
        $result = array();

        if ($staffId) {
            $sql = "select * from hotel_staff where staffid=?";
            $result = $this->db->fetchAssoc($sql, array(
                $staffId
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_staff
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateStaffById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_staff', $info, array(
                'id' => $id
            ));
        }
        return $result;
    }

    /**
     * 单条增加hotel_staff数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addStaff(array $info) {
        $this->db->insert('hotel_staff', $info);
        return $this->db->lastInsertId();
    }
}
