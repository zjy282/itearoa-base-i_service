<?php

/**
 * Convertor for task category
 */
class Convertor_TaskCategory extends Convertor_Base
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
    public function getTaskCategoryListConvertor($list, $count, $param)
    {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $value['pic'] = Enum_Img::getPathByKeyAndType($value['pic']);
            $data ['list'] [] = $value;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }


}