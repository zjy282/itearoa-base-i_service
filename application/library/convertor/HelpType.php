<?php

/**
 * 集团帮助类别转换器类
 */
class Convertor_HelpType extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 集团帮助类别列表结果转换器
     *
     * @param array $list
     *            集团帮助类别列表
     * @param int $count
     *            集团帮助类别总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getTypeListConvertor($list, $count, $param) {
        $data = array();
        $data ['list'] = array();
        foreach ($list as $type) {
            $typeTemp = array();
            $typeTemp['id'] = $type['id'];
            $typeTemp['title_zh'] = $type['title_zh'];
            $typeTemp['title_en'] = $type['title_en'];
            $typeTemp['groupid'] = $type['groupid'];
            $typeTemp['sort'] = $type['sort'];
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 后台集团帮助类别列表结果转换器
     *
     * @param array $list
     *            集团帮助类别列表
     * @param int $count
     *            集团帮助类别总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getAdminTagListConvertor($list, $count, $param) {
        $data = array();
        $data ['list'] = array();
        foreach ($list as $type) {
            $typeTemp = array();
            $typeTemp ['id'] = $type ['id'];
            $typeTemp ['title_lang1'] = $type ['title_lang1'];
            $typeTemp ['title_lang2'] = $type ['title_lang2'];
            $typeTemp ['title_lang3'] = $type ['title_lang3'];
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 集团帮助类别详情
     *
     * @param array $detail
     *            集团帮助类别详情
     * @return multitype:unknown
     */
    public function getTagDetailConvertor($detail) {
        $data = array();
        $data ['id'] = $detail ['id'];
        $data ['title_lang1'] = $detail ['title_lang1'];
        $data ['title_lang2'] = $detail ['title_lang2'];
        $data ['title_lang3'] = $detail ['title_lang3'];
        return $data;
    }
}
