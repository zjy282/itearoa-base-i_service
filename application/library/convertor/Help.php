<?php

/**
 * 帮助转换器类
 */
class Convertor_Help extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 后台帮助列表
     *
     * @param array $HelpList
     *            帮助列表
     * @param array $tagList
     *            帮助标签
     * @param int $HelpCount
     *            帮助总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getAdminHelpListConvertor($HelpList, $HelpCount, $param) {
        $typeIdList = array_column($HelpList, 'typeid');
        if ($typeIdList) {
            $typeModel = new HelpTypeModel();
            $typeInfoList = $typeModel->getHelpTypeList(array('id' => $typeIdList));
            $typeNameList = array_column($typeInfoList, null, 'id');
        }
        $data = array('list' => array());
        foreach ($HelpList as $Help) {
            $newTemp = array();
            $newTemp ['id'] = $Help ['id'];
            $newTemp ['title_zh'] = $Help ['title_zh'];
            $newTemp ['title_en'] = $Help ['title_en'];
            $newTemp ['sort'] = $Help ['sort'];
            $newTemp ['help_zh'] = $Help ['help_zh'];
            $newTemp ['help_en'] = $Help ['help_en'];
            $newTemp ['createtime'] = $Help ['createtime'];
            $newTemp ['updatetime'] = $Help ['updatetime'];
            $newTemp ['status'] = $Help ['status'];
            $newTemp ['groupid'] = $Help ['groupid'];
            $newTemp ['typeid'] = $Help ['typeid'];
            $newTemp ['typeName_zh'] = $typeNameList [$newTemp ['typeid']] ['title_zh'];
            $newTemp ['typeName_en'] = $typeNameList [$newTemp ['typeid']] ['title_en'];
            $data ['list'] [] = $newTemp;
        }
        $data ['total'] = $HelpCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 帮助详情
     *
     * @param array $list
     *            帮助详情
     * @return array
     */
    public function getHelpDetailConvertor($list) {
        $data = array();
        $data ['id'] = $list ['id'];
        $data ['title'] = $this->handlerMultiLang('title', $list);
        $data ['article'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('article', $list));
        $data ['createTime'] = $list ['createtime'];
        $data ['updateTime'] = $list ['updatetime'];
        $data ['status'] = $list ['status'];
        $data ['tagId'] = $list ['tagid'];
        return $data;
    }

    /**
     * 后台帮助详情
     *
     * @param array $list
     *            后台帮助详情
     * @return array
     */
    public function getAdminHelpDetailConvertor($list) {
        $data = array();
        $data ['id'] = $list ['id'];
        $data ['title_lang1'] = $list ['title_lang1'];
        $data ['title_lang2'] = $list ['title_lang2'];
        $data ['title_lang3'] = $list ['title_lang3'];
        $data ['article_lang1'] = $list ['article_lang1'];
        $data ['article_lang2'] = $list ['article_lang2'];
        $data ['article_lang3'] = $list ['article_lang3'];
        $data ['tagId'] = $list ['tagid'];
        $data ['status'] = $list ['status'];
        $data ['createTime'] = $list ['createtime'];
        $data ['updateTime'] = $list ['updatetime'];
        return $data;
    }

    /**
     * 获取集团帮助信息
     */
    public function getGroupHelp($typeList, $helpList) {
        $result = array();
        $langInfo = Yaf_Registry::get('hotelLangInfo');
        $typeList = array_column($typeList, null, 'id');
        foreach ($helpList as $help) {
            $typeId = $help['typeid'];
            if (!$result[$typeId]) {
                $result[$typeId] = array(
                    'type' => $langInfo['lang'] == 'en' ? $typeList[$typeId]['title_en'] : $typeList[$typeId]['title_zh'],
                    'list' => array()
                );
            }
            $dataTemp = array();
            $dataTemp['id'] = $help['id'];
            $dataTemp['title'] = $langInfo['lang'] == 'en' ? $help['title_en'] : $help['title_zh'];
            $dataTemp['help'] = Enum_Img::getPathByKeyAndType($langInfo['lang'] == 'en' ? $help['help_en'] : $help['help_zh']);
            $result[$typeId]['list'][] = $dataTemp;
        }
        $newResult = array();
        foreach ($typeList as $typeId => $info) {
            if ($result[$typeId]) {
                $newResult[] = $result[$typeId];
            }
        }
        return $newResult;
    }
}