<?php

/**
 * APP启动图convertor
 * @author ZXM
 */
class Convertor_AppstartPic extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取当前可用的APP广告图
     */
    public function getEffectiveAppStartPicConvertor(array $result) {
        $data = array(
            'list' => array()
        );
        if ($result) {
            $result = array_column($result, null, 'id');
            krsort($result);
            $result = current($result);
            $dataTemp['pic'] = Enum_Img::getPathByKeyAndType($result['pic']);
            $dataTemp['link'] = $result['link'];
            $data['list'] = $dataTemp;
        }
        return $data;
    }
}