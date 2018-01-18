<?php

/**
 * 物业管理员DAO类
 */
class Dao_HotelAdministrator extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询group_administrator列表
     * @param array 入参
     * @return array
     */
    public function getHotelAdministratorList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_administrator {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_administrator数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getHotelAdministratorCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_administrator {$paramSql['sql']}";
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
            if (is_array($param['id'])) {
                $whereSql[] = 'id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'id = ?';
                $whereCase[] = $param['id'];
            }
        }
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['username'])) {
            $whereSql[] = 'username = ?';
            $whereCase[] = $param['username'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['level'])) {
            $whereSql[] = 'level = ?';
            $whereCase[] = $param['level'];
        }
        if (isset($param['department_id'])) {
            $whereSql[] = 'department = ?';
            $whereCase[] = $param['department_id'];
        }

        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_administrator详情
     * @param int id
     * @return array
     */
    public function getHotelAdministratorDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_administrator where id=?";
            $result = $this->db->fetchAssoc($sql, array($id));
        }

        return $result;
    }

    /**
     * 根据username查询hotel_administrator详情
     *
     * @param
     *            string username
     * @return array
     */
    public function getHotelAdministratorDetailByUsername(string $username): array {
        $result = array();

        if ($username) {
            $sql = "select * from hotel_administrator where username=?";
            $result = $this->db->fetchAssoc($sql, array(
                $username
            ));
            $result = $result ? $result : array();
        }

        return $result;
    }

    /**
     * 根据id更新hotel_administrator
     * @param array 需要更新的数据
     * @param int id
     * @return array
     */
    public function updateHotelAdministratorById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_administrator', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_administrator数据
     * @param array
     * @return int id
     */
    public function addHotelAdministrator(array $info) {
        $this->db->insert('hotel_administrator', $info);
        return $this->db->lastInsertId();
    }
}
