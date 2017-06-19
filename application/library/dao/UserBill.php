<?php

/**
 * 用户账单管理数据层
 */
class Dao_UserBill extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询用户账单列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getUserBillList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_user_bill {$paramSql['sql']} order by date DESC";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询用户账单数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getUserBillCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_user_bill {$paramSql['sql']}";
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
        if ($param['room_no']) {
            if (is_array($param['room_no'])) {
                $whereSql[] = 'room_no in (' . implode(',', $param['room_no']) . ')';
            } else {
                $whereSql[] = 'room_no = ?';
                $whereCase[] = $param['room_no'];
            }
        }
        if ($param['name']) {
            $whereSql[] = 'name = ?';
            $whereCase[] = $param['name'];
        }
        if ($param['hotelid']) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if ($param['userid']) {
            $whereSql[] = 'userid = ?';
            $whereCase[] = $param['userid'];
        }
        if ($param['date']) {
            $whereSql[] = 'date = ?';
            $whereCase[] = $param['date'];
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
     * 根据id查询用户账单详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getUserBillDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_user_bill where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新用户账单
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateUserBillById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_user_bill', $info, array(
                'id' => $id
            ));
        }
        return $result;
    }

    /**
     * 单条增加用户账单数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addUserBill(array $info) {
        $this->db->insert('hotel_user_bill', $info);
        return $this->db->lastInsertId();
    }
}
