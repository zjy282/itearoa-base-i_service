<?php

/**
 * Convertor for task
 */
class Convertor_Task extends Convertor_Base
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
    public function getTaskListConvertor($list, $count, $param)
    {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value ['id'];
            $oneTemp['title_lang1'] = $value ['title_lang1'];
            $oneTemp['title_lang2'] = $value ['title_lang2'];
            $oneTemp['title_lang3'] = $value ['title_lang3'];
            $oneTemp['pic'] = Enum_Img::getPathByKeyAndType($value ['pic']);
            $oneTemp['price'] = $value ['price'];
            $oneTemp['category_id'] = $value['category_id'];
            $oneTemp['category_title1'] = $value ['category_title1'];
            $oneTemp['category_title2'] = $value ['category_title2'];
            $oneTemp['status'] = $value ['status'];

            $processInfo = array();
            $processInfo['department_id'] = $value['department_id'];
            $processInfo['staff_id'] = $value['staff_id'];
            $processInfo['highest_level'] = $value['highest_level'];
            $processInfo['sms'] = $value['sms'];
            $processInfo['email'] = $value['email'];
            $processInfo['level_interval_1'] = $value['level_interval_1'];
            $processInfo['level_interval_2'] = $value['level_interval_2'];
            $processInfo['level_interval_3'] = $value['level_interval_3'];
            $processInfo['level_interval_4'] = $value['level_interval_4'];
            $processInfo['level_interval_5'] = $value['level_interval_5'];

            $oneTemp['process_info'] = $processInfo;
            $data['list'][] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * Convert task order list to output
     *
     * @param $list
     * @param $count
     * @param $param
     * @return array
     */
    public function getTaskOrderListConvertor($list, $count, $param)
    {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value ['id'];
            $oneTemp['userid'] = $value ['userid'];
            $oneTemp['room_no'] = $value['room_no'];
            $oneTemp['task_id'] = $value ['task_id'];
            $oneTemp['count'] = $value ['count'];
            $oneTemp['created_at'] = $value ['created_at'];
            $oneTemp['updated_at'] = $value ['updated_at'];
            $oneTemp['delay'] = $value ['delay'];
            $oneTemp['status'] = $value['status'];
            $oneTemp['admin_id'] = $value ['admin_id'];
            $oneTemp['admin_name'] = $value['hotel_administrator_realname'] ? $value['hotel_administrator_realname'] : $value['hotel_staff_lname'];
            $oneTemp['memo'] = $value ['memo'];
            $oneTemp['tasks_title_lang1'] = $value['tasks_title_lang1'];
            $oneTemp['tasks_title_lang2'] = $value['tasks_title_lang2'];
            $oneTemp['tasks_title_lang3'] = $value['tasks_title_lang3'];

            $oneTemp['tasks_pic'] = Enum_Img::getPathByKeyAndType($value['tasks_pic']);
            $oneTemp['task_categories_title_lang1'] = $value['task_categories_title_lang1'];
            $oneTemp['task_categories_title_lang2'] = $value['task_categories_title_lang2'];
            $oneTemp['task_categories_title_lang3'] = $value['task_categories_title_lang3'];

            $oneTemp['price'] = $value['price'] * $value ['count'];

            $data['list'][] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

}