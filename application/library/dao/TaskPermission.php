<?php

/**
 * Class Dao_TaskPermission
 */
class Dao_TaskPermission extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get task permission list
     *
     * @param array $param
     * @return array
     */
    public function getTaskPermissionList(array $param = array()): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from task_permission {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }


    /**
     * Get count of task_permission
     *
     * @param array $param
     * @return int
     */
    public function getTaskPermissionCount(array $param): int
    {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from task_permission {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * Update task permission by ID
     *
     * @param array $info
     * @param int $id
     * @return bool|number|string
     */
    public function updatePermission(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('task_permission', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * Add new task permission
     *
     * @param array $info
     * @return int
     */
    public function addPermission(array $info): int
    {
        $this->db->insert('task_permission', $info);
        return intval($this->db->lastInsertId());
    }

    /**
     * Common param pre-process
     *
     * @param $param
     * @return array
     */
    private function handlerListParams($param)
    {
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
}
