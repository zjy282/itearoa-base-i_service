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
     * Check if the the order have same room_no
     *
     * @param $orderArray
     * @return bool
     * @throws Exception
     */
    public function hasSameRoomNo($orderArray)
    {

        if (count($orderArray) <= 0) {
            throw new Exception("Order not exist");
        }
        $roomNo = $orderArray[0]['room_no'];
        foreach ($orderArray as $order) {
            if ($order['room_no'] != $roomNo) {
                throw new Exception(Enum_ShoppingOrder::EXCEPTION_DIFFERENT_ROOM, Enum_ShoppingOrder::ORDERS_ROOM_DIFFERENT);
            }
        }
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
}
