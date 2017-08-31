<?php

/**
 * 活动订单数据层
 */
class Dao_ActivityOrder extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_activity_order列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getActivityOrderList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_activity_order {$paramSql['sql']} order by creattime desc";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_activity_order数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getActivityOrderCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_activity_order {$paramSql['sql']}";
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
        if (isset($param['name'])) {
            $whereSql[] = 'name = ?';
            $whereCase[] = $param['name'];
        }
        if (isset($param['phone'])) {
            $whereSql[] = 'phone = ?';
            $whereCase[] = $param['phone'];
        }
        if (isset($param['activityid'])) {
            $whereSql[] = 'activityid = ?';
            $whereCase[] = $param['activityid'];
        }
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['groupid'])) {
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
     * 根据id查询hotel_activity_order详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getActivityOrderDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_activity_order where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_activity_order
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateActivityOrderById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_activity_order', $info, $id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_activity_order数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addActivityOrder(array $info) {
        $this->db->insert('hotel_activity_order', $info);
        return $this->db->lastInsertId();
    }
}
