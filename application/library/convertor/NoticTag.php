<?php

/**
 * 酒店通知标签转换器类
 */
class Convertor_NoticTag extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 酒店通知标签结果转换器
     *
     * @param array $list
     *            酒店通知标签
     * @param int $count
     *            酒店通知标签总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getTagListConvertor($list, $count, $param) {
        $data = array();
        $data ['list'] = array();
        foreach ($list as $type) {
            $typeTemp = array();
            $typeTemp ['id'] = $type ['id'];
            $typeTemp ['title'] = $this->handlerMultiLang('title', $type);
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = $count;
        return $data;
    }

    /**
     * 后台酒店通知标签结果转换器
     *
     * @param array $list
     *            酒店通知标签
     * @param int $count
     *            酒店通知标签总数
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
     * 酒店通知标签详情结果转换器
     *
     * @param array $detail
     *            酒店通知标签
     * @return array
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
