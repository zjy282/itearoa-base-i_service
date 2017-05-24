<?php

/**
 * APP启动图转换器类
 */
class Convertor_AppstartPic extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取当前可用的APP广告图
     *
     * @param array $result
     *            可用的APP广告图
     * @return array
     */
    public function getEffectiveAppStartPicConvertor(array $result) {
        $data = array('list' => array());
        if ($result) {
            $result = array_column($result, null, 'id');
            krsort($result);
            $result = current($result);
            $dataTemp ['pic'] = Enum_Img::getPathByKeyAndType($result ['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750);
            $dataTemp ['link'] = $result ['link'];
            $data ['list'] = $dataTemp;
        }
        return $data;
    }

    /**
     * APP广告图列表数据
     *
     * @param array $list
     *            APP广告图列表数据
     * @param int $count
     *            APP广告图列表数据总数
     * @param array $param
     *            扩展参数
     * @return multitype:multitype: unknown number
     */
    public function getAppstartPicListConvertor($list, $count, $param) {
        $data = array('list' => array());
        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['pic'] = $value ['pic'];
            $oneTemp ['link'] = $value ['link'];
            $oneTemp ['status'] = $value ['status'];
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}