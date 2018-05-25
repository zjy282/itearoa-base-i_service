<?php

/**
 * 体验购物管理数据层
 */
class Dao_Shopping extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_shopping列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getShoppingList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerShoppingListParams($param);
        $sql = "select * from hotel_shopping {$paramSql['sql']} order by sort";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_news数量
     *
     * @param array $param
     * @return int
     */
    public function getShoppingCount(array $param): int {
        $paramSql = $this->handlerShoppingListParams($param);
        $sql = "select count(1) as count from hotel_shopping {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerShoppingListParams($param) {
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
        if (isset($param['tagid'])) {
            $whereSql[] = 'tagid = ?';
            $whereCase[] = $param['tagid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['title'])) {
            $whereSql[] = '(title_lang1 = ? or title_lang2 = ? or title_lang3 = ?)';
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_shopping详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getShoppingDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_shopping where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_shopping
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateShoppingById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_shopping', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_shopping数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addShopping(array $info) {
        $this->db->insert('hotel_shopping', $info);
        return $this->db->lastInsertId();
    }
}
