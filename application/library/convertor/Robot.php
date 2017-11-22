<?php

/**
 * Convertor for robot
 */
class Convertor_Robot extends Convertor_Base
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Convert data list for output
     *
     * @param $list
     * @param $count
     * @param $param
     * @return array
     */
    public function getRobotPositionListConvertor($list, $count, $param)
    {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['hotelid'] = $value ['hotelid'];
            $oneTemp ['userid'] = $value ['userid'];
            $oneTemp ['position'] = $value ['position'];
            $oneTemp ['robot_position'] = $value ['robot_position'];
            $oneTemp ['type'] = $value ['type'];
            $oneTemp ['create_at'] = $value ['create_at'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}