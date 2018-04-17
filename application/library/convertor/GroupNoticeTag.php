<?php

/**
 * 集团通知标签转换器类
 */
class Convertor_GroupNoticeTag extends Convertor_Base
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 后台集团通知标签结果转换器
     *
     * @param array $list
     *            集团通知标签
     * @param int $count
     *            集团通知标签总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getAdminTagListConvertor($list, $count, $param)
    {
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
     * 集团通知标签列表结果转换器
     *
     * @param array $list
     *            新闻标签列表
     * @param int $count
     *            新闻标签总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getTagListConvertor($list, $count, $param)
    {
        $data = array();
        $data ['list'] = array();
        foreach ($list as $type) {
            $typeTemp = array();
            $typeTemp ['id'] = $type ['id'];
            $typeTemp ['title'] = $type ['title_lang' . Enum_Lang::getLangIndex($param['lang'])];
            $data ['list'] [] = $typeTemp;
        }
        $data ['total'] = $count;
        return $data;
    }

    /**
     * 集团通知标签详情结果转换器
     *
     * @param array $detail
     *            集团通知标签
     * @return array
     */
    public function getTagDetailConvertor($detail, $lang)
    {
        $data = array();
        $data ['id'] = $detail ['id'];
        $data ['title'] = $detail ['title_lang' . Enum_Lang::getLangIndex($lang)];
        return $data;
    }
}
