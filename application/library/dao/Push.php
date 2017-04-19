<?php

class Dao_Push extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_push列表
     * @param array 入参
     * @return array
     */
    public function getPushList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from iservice_push {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询iservice_push数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPushCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from iservice_push {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

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
        if (isset($param['type'])) {
            $whereSql[] = 'type = ?';
            $whereCase[] = $param['type'];
        }
        if (isset($param['result'])) {
            if ($param['result'] > 0) {
                $whereSql[] = 'result <> ?';
            } else {
                $whereSql[] = 'result = ?';
            }
            $whereCase[] = 0;
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询iservice_push详情
     * @param int id
     * @return array
     */
    public function getPushDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from iservice_push where id=?";
            $result = $this->db->fetchAssoc($sql, array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_push
     * @param array 需要更新的数据
     * @param int id
     * @return array
     */
    public function updatePushById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('iservice_push', $info, $id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_push数据
     * @param array
     * @return int id
     */
    public function addPush(array $info) {
        $this->db->insert('iservice_push', $info);
        return $this->db->lastInsertId();
    }
}
