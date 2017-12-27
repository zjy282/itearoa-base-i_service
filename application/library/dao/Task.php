<?php

/**
 * Class Dao_Task
 */
class Dao_Task extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get task list
     *
     * @param array $param
     * @return array
     */
    public function getTaskList(array $param = array()): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select t.*, tc.title_lang1 as category_title1, tc.title_lang2 as category_title2
                from tasks as t LEFT JOIN task_categories as tc ON t.category_id = tc.id {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }


    /**
     * Get count of tasks
     *
     * @param array $param
     * @return int
     */
    public function getTasksCount(array $param): int
    {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from tasks as t LEFT JOIN task_categories as tc ON t.category_id = tc.id {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * Update task category by ID
     *
     * @param array $info
     * @param int $id
     * @return bool|number|string
     */
    public function updateTask(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('tasks', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * Add new task category
     *
     * @param array $info
     * @return int
     */
    public function addTask(array $info): int
    {
        $this->db->insert('tasks', $info);
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
                $whereSql[] = 't.id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 't.id = ?';
                $whereCase[] = $param['id'];
            }
        }

        if (isset($param['hotelid'])) {
            if (is_array($param['hotelid'])) {
                $whereSql[] = 'tc.hotelid in (' . implode(',', $param['hotelid']) . ')';
            } else {
                $whereSql[] = 'tc.hotelid = ?';
                $whereCase[] = $param['hotelid'];
            }
        }

        if (isset($param['category_id'])) {
            if (is_array($param['category_id'])) {
                $whereSql[] = 'tc.id in (' . implode(',', $param['category_id']) . ')';
            } else {
                $whereSql[] = 'tc.id = ?';
                $whereCase[] = $param['category_id'];
            }
        }

        if (isset($param['status'])) {
            if (is_array($param['status'])) {
                $whereSql[] = 't.status in (' . implode(',', $param['status']) . ')';
            } else {
                $whereSql[] = 't.status = ?';
                $whereCase[] = $param['status'];
            }
        }

        if (isset($param['title_lang1'])) {
            if (is_string($param['title_lang1'])) {
                $whereSql[] = 't.title_lang1 = ?';
                $whereCase[] = $param['title_lang1'];
            }
        }

        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }
}
