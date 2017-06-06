<?php

/**
 * 集团通知转换器类
 */
class Convertor_GroupNotice extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 集团通知列表结果转换器
     *
     * @param array $noticList
     *            集团通知列表
     * @param array $tagList
     *            集团通知标签列表
     * @param int $noticCount
     *            集团通知总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getNoticListConvertor($noticList, $tagList, $noticCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew [$tag ['id']] = $this->handlerMultiLang('title', $tag);
        }
        $data = array('list' => array());
        foreach ($noticList as $notic) {
            $newTemp = array();
            $newTemp ['id'] = $notic ['id'];
            $newTemp ['title'] = $notic['title'];
            $newTemp ['article'] = $notic['article'];
            $newTemp ['pdf'] = $notic['pdf'] ? Enum_Img::getPathByKeyAndType($notic['pdf']) : '';
            $newTemp ['video'] = $notic['video'] ? Enum_Img::getPathByKeyAndType($notic['video']) : '';
            $newTemp ['tagId'] = $notic ['tagid'];
            $newTemp ['pic'] = $notic ['pic'];
            $newTemp ['tagName'] = $tagListNew [$newTemp ['tagId']];
            $newTemp ['createtime'] = $notic ['createtime'];
            $newTemp ['updatetime'] = $notic ['updatetime'];
            $data ['list'] [] = $newTemp;
        }
        $data ['total'] = $noticCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 后台集团通知列表结果转换器
     *
     * @param array $noticList
     *            集团通知列表
     * @param array $tagList
     *            集团通知标签列表
     * @param int $noticCount
     *            集团通知总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getAdminNoticListConvertor($noticList, $tagList, $noticCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew [$tag ['id']] ['title'] = $tag ['title'];
        }
        $data = array('list' => array());
        foreach ($noticList as $notic) {
            $noticTemp = array();
            $noticTemp ['id'] = $notic ['id'];
            $noticTemp ['title'] = $notic ['title'];
            $noticTemp ['article'] = $notic ['article'];
            $noticTemp ['tagId'] = $notic ['tagid'];
            $noticTemp ['status'] = $notic ['status'];
            $noticTemp ['tagName'] = $tagListNew [$noticTemp ['tagId']] ['title'];
            $noticTemp ['sort'] = $notic ['sort'];
            $noticTemp ['pdf'] = $notic ['pdf'];
            $noticTemp ['pic'] = $notic ['pic'];
            $noticTemp ['video'] = $notic ['video'];
            $noticTemp ['createTime'] = $notic ['createtime'];
            $noticTemp ['updateTime'] = $notic ['updatetime'];
            $data ['list'] [] = $noticTemp;
        }
        $data ['total'] = $noticCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 集团通知详情结果转换器
     *
     * @param array $list
     *            集团通知详情
     * @return array
     */
    public function getNoticDetailConvertor($list) {
        $data = array();
        $data ['id'] = $list ['id'];
        $data ['title'] = $list['title'];
        $data ['article'] = $list['article'];
        $data ['createTime'] = $list ['createtime'];
        $data ['updateTime'] = $list ['updatetime'];
        $data ['status'] = $list ['status'];
        $data ['pic'] = $list ['pic'];
        $data ['tagId'] = $list ['tagid'];
        return $data;
    }

    /**
     * 后台集团通知详情结果转换器
     *
     * @param array $list
     *            集团通知详情
     * @return array
     */
    public function getAdminNoticDetailConvertor($list) {
        $data = array();
        $data ['id'] = $list ['id'];
        $data ['title'] = $list ['title'];
        $data ['article'] = $list ['article'];
        $data ['tagId'] = $list ['tagid'];
        $data ['pic'] = $list ['pic'];
        $data ['status'] = $list ['status'];
        $data ['createTime'] = $list ['createtime'];
        $data ['updateTime'] = $list ['updatetime'];
        return $data;
    }
}
