<?php

/**
 * 电话黄页管理数据层
 */
class Dao_Tel extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_tel列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getTelList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_tel {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_tel数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getTelCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_tel {$paramSql['sql']}";
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
        if (isset($param['title'])) {
            $whereSql[] = '(title_lang1 = ? or title_lang2 = ? or title_lang3 = ?)';
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
        }
        if (isset($param['tel'])) {
            $whereSql[] = 'tel = ?';
            $whereCase[] = $param['tel'];
        }
        if (isset($param['typeid'])) {
            $whereSql[] = 'typeid = ?';
            $whereCase[] = $param['typeid'];
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
     * 根据id查询hotel_tel详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getTelDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_tel where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_tel
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateTelById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_tel', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_tel数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addTel(array $info) {
        $this->db->insert('hotel_tel', $info);
        return $this->db->lastInsertId();
    }
}
