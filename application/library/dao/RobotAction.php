<?php

/**
 * Class Dao_RobotAction
 *
 * Use for robot API call log
 *
 */
class Dao_RobotAction extends Dao_Base
{
    /**
     * table fields
     *
     * id
    userid
    hotelid
    params
    result
    create_at
     */


    /**
     * Dao_RobotAction constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add new robot action
     *
     * @param array $info
     * @return int
     */
    public function addRobotAction(array $info): int
    {
        $this->db->insert('robot_action', $info);
        return intval($this->db->lastInsertId());
    }
    
}
