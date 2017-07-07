<?php

/**
 * RSS转换器类
 */
class Convertor_Rss extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * RSS转换器
     *
     * @param array $list
     *            POI标签
     * @param int $count
     *            POI标签总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getRssListConvertor($list, $count, $param) {
        $data = array();
        $data ['list'] = array();
        $typeIdlist = array_column($list, 'typeid');
        $rssTypeModel = new RssTypeModel();
        $typeInfoList = $rssTypeModel->getRssTypeList(array('id' => $typeIdlist));
        $typeNameList = array_column($typeInfoList, 'title', 'id');
        $typeEnNameList = array_column($typeInfoList, 'title_en', 'id');
        foreach ($list as $type) {
            $typeTemp = array();
            $typeTemp ['id'] = $type ['id'];
            $typeTemp ['name_zh'] = $type ['name_zh'];
            $typeTemp ['name_en'] = $type ['name_en'];
            $typeTemp ['rss'] = $type ['rss'];
            $typeTemp ['typeid'] = $type ['typeid'];
            $typeTemp ['typename'] = $typeNameList[$type ['typeid']];
            $typeTemp ['typeenname'] = $typeEnNameList[$type ['typeid']];
            $typeTemp ['createtime'] = $type ['createtime'];
            $typeTemp ['updatetime'] = $type ['updatetime'];
            $typeTemp ['status'] = $type ['status'];
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 根据物业ID获取物业的RSS列表转换器
     * @return array
     */
    public function getHotelRssListConvertor($list) {
        $list = Util_Tools::filterIdListArray(explode(",", $list));
        if ($list) {
            $rssModel = new RssModel();
            $rssInfoList = $rssModel->getRssList(array('id' => $list, 'status' => 1));
        }

        $typeIdlist = array_column($rssInfoList, 'typeid');
        if ($typeIdlist) {
            $rssTypeModel = new RssTypeModel();
            $typeInfoList = $rssTypeModel->getRssTypeList(array('id' => $typeIdlist));
            $typeNameList = array_column($typeInfoList, 'title', 'id');
            $typeNameEnList = array_column($typeInfoList, 'title_en', 'id');
        }
        $langInfo = Yaf_Registry::get('hotelLangInfo');
        $data ['list'] = array();
        foreach ($rssInfoList as $rss) {
            $typeTemp = array();
            $typeTemp ['id'] = $rss ['id'];
            $typeTemp ['name'] = $langInfo['lang'] == 'zh' ? $rss ['name_zh'] : $rss ['name_en'];
            $typeTemp ['rss'] = $rss ['rss'];
            $typeTemp ['typeid'] = $rss ['typeid'];
            $typeTemp ['typename'] = $typeNameList[$rss ['typeid']];
            $typeTemp ['typeenname'] = $typeNameEnList[$rss ['typeid']];
            $typeTemp ['createtime'] = $rss ['createtime'];
            $typeTemp ['updatetime'] = $rss ['updatetime'];
            $typeTemp ['status'] = $rss ['status'];
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = count($rssInfoList);
        return $data;
    }
}