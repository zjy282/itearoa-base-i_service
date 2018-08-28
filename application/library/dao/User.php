<?php

/**
 * 用户管理数据层
 */
class Dao_User extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_user列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getUserList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_user {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_user数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getUserCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_user {$paramSql['sql']}";
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
        if (isset($param['oid'])) {
            if (is_array($param['oid'])) {
                $whereSql[] = 'oid in (' . implode(',', $param['oid']) . ')';
            } else {
                $whereSql[] = 'oid = ?';
                $whereCase[] = $param['oid'];
            }
        }
        if ($param['room_no']) {
            if (is_array($param['room_no'])) {
                foreach ($param['room_no'] as &$roomNo) {
                    $roomNo = $this->db->getConnection()->quote($roomNo);
                }
                $whereSql[] = 'room_no in (' . implode(',', $param['room_no']) . ')';
            } else {
                $whereSql[] = 'room_no = ?';
                $whereCase[] = $param['room_no'];
            }
        }
        if ($param['fullname']) {
            $whereSql[] = 'fullname = ?';
            $whereCase[] = $param['fullname'];
        }
        if ($param['hotelid']) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if ($param['groupid']) {
            $whereSql[] = 'groupid = ?';
            $whereCase[] = $param['groupid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_user详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getUserDetail(int $id) {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_user where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据oid查询hotel_user详情
     *
     * @param
     *            string oid
     * @return array
     */
    public function getUserDetailByOId($oId) {
        $result = array();

        if ($oId) {
            $sql = "select * from hotel_user where oid=?";
            $result = $this->db->fetchAssoc($sql, array(
                $oId
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_user
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateUserById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_user', $info, array(
                'id' => $id
            ));
        }
        return $result;
    }

    /**
     * 单条增加hotel_user数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addUser(array $info) {
        $this->db->insert('hotel_user', $info);
        return $this->db->lastInsertId();
    }
}
