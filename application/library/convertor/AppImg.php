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
}