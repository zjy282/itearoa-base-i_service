<?php

/**
 * APP启动图convertor
 * @author ZXM
 */
class Convertor_AppImg extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取最新可用的启动图
     */
    public function availableAppImgConvertor(array $result) {
        $data = array();
        $data['pic'] = Enum_Img::getPathByKeyAndType($result['pickey']);
        return $data;
    }

    public function getAppImgListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['pickey'] = $value['pickey'];
            $oneTemp['status'] = $value['status'];
            $oneTemp['createtime'] = $value['createtime'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}