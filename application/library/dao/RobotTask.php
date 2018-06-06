<?php

/**
 * Robot deliver DAO class
 */
class Dao_RobotTask extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param array $info
     * @return string
     */
    public function addTask(array $info)
    {
        $this->db->insert('robot_task', $info);
        return $this->db->lastInsertId();
    }

    /**
     * @param array $info
     * @param int|array $id
     * @return bool|number|string
     */
    public function updateTask(array $info, $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('robot_task', $info, array(
                'id' => $id
            ));
        }

        return $result;
    }

    /**
     * Check if the the order have same room_no, if yes then return the room no
     *
     * @param $orderArray
     * @return string
     * @throws Exception
     */
    public function checkRoomNo($orderArray)
    {
        if (count($orderArray) <= 0) {
            throw new Exception("Order not exist");
        }
        $roomNo = strval($orderArray[0]['user']['room_no']);
        foreach ($orderArray as $order) {
            if ($order['user']['room_no'] != $roomNo) {
                throw new Exception(Enum_ShoppingOrder::EXCEPTION_DIFFERENT_ROOM, Enum_ShoppingOrder::ORDERS_ROOM_DIFFERENT);
            }
        }
        return $roomNo;
    }

    /**
     * Get robot task detail by ID
     *
     * @param int $id
     * @return array
     */
    public function getRobotTaskDetail(int $id): array
    {
        $result = array();

        if ($id) {
            $sql = "select * from robot_task where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        return is_array($result) ? $result : array();
    }

    /**
     * @param array $param
     * @return array
     */
    public function getRobotTaskList(array $param): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "SELECT *  FROM robot_task {$paramSql['sql']} ORDER BY id DESC";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * @param array $param
     * @return int
     */
    public function getRobotTaskListCount(array $param): int
    {
        $paramSql = $this->handlerListParams($param);
        $sql = "SELECT COUNT(1) AS count FROM robot_task {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
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
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }

        if (isset($param['userid'])) {
            $whereSql[] = 'userid = ?';
            $whereCase[] = $param['userid'];
        }

        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }

        if ($param['orders'] == RobotModel::ROBOT_TASK_GETITEM) {
            $whereSql[] = 'orders = ?';
            $whereCase[] = $param['orders'];
        }


        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }
}
