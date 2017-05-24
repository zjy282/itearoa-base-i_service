<?php

/**
 * APP启动图转换器类
 */
class Convertor_AppImg extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 最新可用的启动图的数据转换器
     *
     * @param array $result
     *            最新可用的启动图的数据
     * @return array
     */
    public function availableAppImgConvertor(array $result) {
        $data = array();
        $data ['pic'] = Enum_Img::getPathByKeyAndType($result ['pickey'], Enum_Img::PIC_TYPE_KEY_WIDTH750);
        return $data;
    }

    /**
     * app启动图列表数据转换器
     *
     * @param array $list
     *            app启动图列表数据
     * @param int $count
     *            app启动图列表数据总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getAppImgListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['pickey'] = $value ['pickey'];
            $oneTemp ['status'] = $value ['status'];
            $oneTemp ['createtime'] = $value ['createtime'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}