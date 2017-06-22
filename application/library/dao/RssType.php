<?php

/**
 * RSS类型管理数据层
 */
class Dao_RssType extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询RSS类型列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getRssTypeList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from iservice_rss_type {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询RSS类型数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getRssTypeCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from iservice_rss_type {$paramSql['sql']}";
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
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询RSS类型详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getRssTypeDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from iservice_rss_type where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新RSS类型
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateRssTypeById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('iservice_rss_type', $info, array(
                'id' => $id
            ));
        }
        return $result;
    }

    /**
     * 单条增加RSS类型数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addRssType(array $info) {
        $this->db->insert('iservice_rss_type', $info);
        return $this->db->lastInsertId();
    }
}
