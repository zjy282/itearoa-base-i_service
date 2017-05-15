<?php

/**
 * 集团管理员DAO类
 */
class Dao_Administrator extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询group_administrator列表
     * @param array 入参
     * @return array
     */
    public function getAdministratorList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from group_administrator {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询group_administrator数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAdministratorCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from group_administrator {$paramSql['sql']}";
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
        if (isset($param['groupid'])) {
            $whereSql[] = 'groupid = ?';
            $whereCase[] = $param['groupid'];
        }
        if (isset($param['username'])) {
            $whereSql[] = 'username = ?';
            $whereCase[] = $param['username'];
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
     * 根据id查询group_administrator详情
     * @param int id
     * @return array
     */
    public function getAdministratorDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from group_administrator where id=?";
            $result = $this->db->fetchAssoc($sql, array($id));
        }

        return $result;
    }

    /**
     * 根据username查询group_administrator详情
     *
     * @param
     *            string username
     * @return array
     */
    public function getAdministratorDetailByUsername(string $username): array {
        $result = array();

        if ($username) {
            $sql = "select * from group_administrator where username=?";
            $result = $this->db->fetchAssoc($sql, array(
                $username
            ));
            $result = $result ? $result : array();
        }

        return $result;
    }

    /**
     * 根据id更新group_administrator
     * @param array 需要更新的数据
     * @param int id
     * @return array
     */
    public function updateAdministratorById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('group_administrator', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加group_administrator数据
     * @param array
     * @return int id
     */
    public function addAdministrator(array $info) {
        $this->db->insert('group_administrator', $info);
        return $this->db->lastInsertId();
    }
}
