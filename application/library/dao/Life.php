<?php

/**
 * 雅士阁生活管理数据层
 */
class Dao_Life extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_life列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getLifeList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerLifeListParams($param);
        $sql = "select * from hotel_life {$paramSql['sql']} order by sort";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_life数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getLifeCount(array $param): int {
        $paramSql = $this->handlerLifeListParams($param);
        $sql = "select count(1) as count from hotel_life {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerLifeListParams($param) {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['typeid'])) {
            $whereSql[] = 'typeid = ?';
            $whereCase[] = $param['typeid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['id'])) {
            $whereSql[] = 'id = ?';
            $whereCase[] = $param['id'];
        }
        if (isset($param['name'])) {
            $whereSql[] = '(name_lang1 = ? or name_lang2 = ? or name_lang2 = ?)';
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
     * 根据id查询hotel_life详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getLifeDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_life where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_life
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateLifeById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_life', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_life数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addLife(array $info) {
        $this->db->insert('hotel_life', $info);
        return $this->db->lastInsertId();
    }
}
