<?php

/**
 * 体验购物订单管理数据层
 */
class Dao_ShoppingOrder extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_shopping_order列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getShoppingOrderList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerShoppingOrderListParams($param);
        $sql = "select * from hotel_shopping_order {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_shopping_order数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getShoppingOrderCount(array $param): int {
        $paramSql = $this->handlerShoppingOrderListParams($param);
        $sql = "select count(1) as count from hotel_shopping_order {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerShoppingOrderListParams() {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['shoppingid'])) {
            $whereSql[] = 'shoppingid = ?';
            $whereCase[] = $param['shoppingid'];
        }
        if (isset($param['userid'])) {
            $whereSql[] = 'userid = ?';
            $whereCase[] = $param['userid'];
        }
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if ($param['status']) {
            if (is_array($param['status'])) {
                $whereSql[] = 'status in (' . implode(',', $param['status']) . ')';
            } else {
                $whereSql[] = 'status = ?';
                $whereCase[] = $param['status'];
            }
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_shopping_order详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getShoppingOrderDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_shopping_order where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_shopping_order
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateShoppingOrderById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_shopping_order', $info, array(
                'id' => $id
            ));
        }

        return $result;
    }

    /**
     * 单条增加hotel_shopping_order数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addShoppingOrder(array $info) {
        $this->db->insert('hotel_shopping_order', $info);
        return $this->db->lastInsertId();
    }
}
