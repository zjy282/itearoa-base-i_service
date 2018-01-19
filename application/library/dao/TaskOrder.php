<?php

/**
 * Class Dao_TaskOrder
 */
class Dao_TaskOrder extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get task order list
     *
     * @param array $param
     * @return array
     */
    public function getTaskOrderList(array $param = array()): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "SELECT task_orders.*,
                tasks.title_lang1 AS tasks_title_lang1, tasks.title_lang2 AS tasks_title_lang2, tasks.pic AS tasks_pic, tasks.price,
                task_categories.title_lang1 AS task_categories_title_lang1, task_categories.title_lang2 AS task_categories_title_lang2,
                hotel_administrator.realname AS hotel_administrator_realname,
                hotel_staff.lname AS hotel_staff_lname
                  FROM task_orders
                  LEFT JOIN tasks ON  task_orders.task_id = tasks.id
                  LEFT JOIN task_categories ON  tasks.category_id = task_categories.id
                  LEFT JOIN hotel_staff ON task_orders.admin_id = hotel_staff.id
                  LEFT JOIN hotel_administrator ON  hotel_staff.admin_id = hotel_administrator.id {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }


    /**
     * Get count of task orders
     *
     * @param array $param
     * @return int
     */
    public function getTaskOrderCount(array $param): int
    {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from task_orders
                  LEFT JOIN tasks ON  task_orders.task_id = tasks.id
                  LEFT JOIN task_categories ON  tasks.category_id = task_categories.id {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * Get task order msg detail
     *
     * @param int $id
     * @return array
     */
    public function getTaskOrderMsgDetail(int $id) : array
    {
        $paramSql = $this->handlerListParams(array('id' => $id));
        $sql = " SELECT task_orders.*, 
                  t.title_lang1 AS t_title1, t.title_lang2 AS t_title2, t.title_lang3 as t_title3,
                  t.pic, t.price, t.highest_level, t.level_interval_1, t.level_interval_2, t.level_interval_3, 
                  t.level_interval_4, t.level_interval_5, t.sms, t.email as is_email,t.department_id, t.staff_id,
                  ha.realname, ha.email, ha.phone, ha.onduty, hu.language as hu_language, hu.fullname, hu.hotelid,hu.groupid,
                  tc.title_lang1 AS tc_title_lang1, tc.title_lang2 AS tc_title_lang2, tc.title_lang3 AS tc_title_lang3
                FROM task_orders 
                LEFT JOIN tasks AS t ON task_orders.task_id = t.id 
                LEFT JOIN task_categories AS tc ON t.category_id = tc.id
                LEFT JOIN hotel_staff AS hs ON t.staff_id = hs.id
                LEFT JOIN hotel_user AS hu ON task_orders.userid = hu.id
                LEFT JOIN hotel_administrator AS ha ON hs.admin_id = ha.id
                 {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }


    /**
     * Update task order by ID
     *
     * @param array $info
     * @param int $id
     * @return bool|number|string
     */
    public function updateTaskOrder(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('task_orders', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * Add a new task order
     *
     * @param array $info
     * @return int
     */
    public function addTaskOrder(array $info): int
    {
        $this->db->insert('task_orders', $info);
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
                $whereSql[] = 'task_orders.id in (?)';
                $whereCase[] = implode(',', $param['id']);
            } else {
                $whereSql[] = 'task_orders.id = ?';
                $whereCase[] = $param['id'];
            }
        }

        if (isset($param['userid'])) {
            if (is_int($param['userid'])) {
                $whereSql[] = 'task_orders.userid = ?';
                $whereCase[] = $param['userid'];
            }
        }

        if (isset($param['room_no'])) {
            if (is_int($param['room_no'])) {
                $whereSql[] = 'task_orders.room_no = ?';
                $whereCase[] = $param['room_no'];
            }
        }

        if (isset($param['task_id'])) {
            if (is_int($param['task_id'])) {
                $whereSql[] = 'task_orders.task_id = ?';
                $whereCase[] = $param['task_id'];
            }
        }

        if (isset($param['category_id'])) {
            if (is_array($param['category_id'])) {
                $whereSql[] = 'task_categories.id in (?)';
                $whereCase[] = implode(',', $param['category_id']);
            } else {
                $whereSql[] = 'task_categories.id = ?';
                $whereCase[] = $param['category_id'];
            }
        }

        if (isset($param['status'])) {
            if (is_array($param['status'])) {
                $whereSql[] = 'task_orders.status in (?)';
                $whereCase[] = implode(',', $param['status']);
            } else {
                $whereSql[] = 'task_orders.status = ?';
                $whereCase[] = $param['status'];
            }
        }


        if (isset($param['department_id'])) {
            if (is_array($param['department_id'])) {
                $whereSql[] = 'tasks.department_id in (?)';
                $whereCase[] = implode(',', $param['department_id']);
            } else {
                $whereSql[] = 'tasks.department_id = ?';
                $whereCase[] = $param['department_id'];
            }
        }

        if (isset($param['staff_id'])) {
            if (is_array($param['staff_id'])) {
                $whereSql[] = 'tasks.staff_id in (?)';
                $whereCase[] = implode(',', $param['staff_id']);
            } else {
                $whereSql[] = 'tasks.staff_id = ?';
                $whereCase[] = $param['staff_id'];
            }
        }

        if (isset($param['admin_id'])) {
            if (is_array($param['admin_id'])) {
                $whereSql[] = 'task_orders.admin_id in (?)';
                $whereCase[] = implode(',', $param['admin_id']);
            } else {
                $whereSql[] = 'task_orders.admin_id = ?';
                $whereCase[] = $param['admin_id'];
            }
        }

        if (isset($param['hotelid'])) {
            if (is_array($param['hotelid'])) {
                $whereSql[] = 'task_categories.hotelid in (?)';
                $whereCase[] = implode(',', $param['hotelid']);
            } else {
                $whereSql[] = 'task_categories.hotelid = ?';
                $whereCase[] = $param['hotelid'];
            }
        }


        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }
}
