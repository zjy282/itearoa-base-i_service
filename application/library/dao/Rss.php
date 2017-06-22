<?php

/**
 * RSS管理数据层
 */
class Dao_Rss extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询RSS列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getRssList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from iservice_rss {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询RSS数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getRssCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from iservice_rss {$paramSql['sql']}";
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
     * 根据id查询RSS详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getRssDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from iservice_rss where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新RSS
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateRssById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('iservice_rss', $info, array(
                'id' => $id
            ));
        }
        return $result;
    }

    /**
     * 单条增加RSS数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addRss(array $info) {
        $this->db->insert('iservice_rss', $info);
        return $this->db->lastInsertId();
    }
}
