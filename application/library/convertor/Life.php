<?php

/**
 * 雅士阁生活转换器类
 */
class Convertor_Life extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 雅士阁生活列表结果转换器
     *
     * @param array $lifeList
     *            雅士阁生活列表
     * @param int $lifeCount
     *            雅士阁生活总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getLifeListConvertor($lifeList, $lifeCount, $param) {
        $data = array('list' => array());
        $typeIdList = array_column($lifeList, 'typeid');
        if ($typeIdList) {
            $lifeTypeModel = new LifeTypeModel();
            $lifeTypeList = $lifeTypeModel->getLifeTypeList(array('id' => $typeIdList));
            $lifeTypeInfoList = array_column($lifeTypeList, null, 'id');
        }
        foreach ($lifeList as $lifes) {
            $lifeTemp = array();
            $lifeTemp ['id'] = $lifes ['id'];
            $lifeTemp ['name'] = $this->handlerMultiLang('name', $lifes);
            $lifeTemp ['address'] = $this->handlerMultiLang('address', $lifes);
            $lifeTemp ['type'] = $this->handlerMultiLang('title', $lifeTypeInfoList[$lifes['typeid']]);
            $lifeTemp ['tel'] = $lifes ['tel'];
            $lifeTemp ['introduct'] = $this->handlerMultiLang('introduct', $lifes);
            $lifeTemp ['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $lifes));
            $lifeTemp ['pdf'] = $lifes['pdf'] ? Enum_Img::getPathByKeyAndType($lifes['pdf']) : '';
            $lifeTemp ['video'] = $lifes['video'] ? Enum_Img::getPathByKeyAndType($lifes['video']) : '';
            $lifeTemp ['pic'] = $lifes['pic'] ? Enum_Img::getPathByKeyAndType($lifes['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750) : '';
            $lifeTemp ['lat'] = $lifes ['lat'];
            $lifeTemp ['lng'] = $lifes ['lng'];
            $data ['list'] [] = $lifeTemp;
        }
        $data ['total'] = $lifeCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 后台雅士阁生活列表结果转换器
     *
     * @param array $lifeList
     *            雅士阁生活列表
     * @param int $lifeCount
     *            雅士阁生活总数
     * @param array $param
     *            扩展参数
     * @param array $typeList
     *            生活类型列表
     * @return array
     */
    public function getAdminLifeListConvertor($lifeList, $lifeCount, $param, $typeList) {
        $data = array('list' => array());
        $typeListNew = array();
        foreach ($typeList as $type) {
            $typeListNew [$type ['id']] ['titleLang1'] = $type ['title_lang1'];
            $typeListNew [$type ['id']] ['titleLang2'] = $type ['title_lang2'];
            $typeListNew [$type ['id']] ['titleLang3'] = $type ['title_lang3'];
        }
        foreach ($lifeList as $lifes) {
            $lifeTemp = array();
            $lifeTemp ['id'] = $lifes ['id'];
            $lifeTemp ['name_lang1'] = $lifes ['name_lang1'];
            $lifeTemp ['name_lang2'] = $lifes ['name_lang2'];
            $lifeTemp ['name_lang3'] = $lifes ['name_lang3'];
            $lifeTemp ['address_lang1'] = $lifes ['address_lang1'];
            $lifeTemp ['address_lang2'] = $lifes ['address_lang2'];
            $lifeTemp ['address_lang3'] = $lifes ['address_lang3'];
            $lifeTemp ['tel'] = $lifes ['tel'];
            $lifeTemp ['introduct_lang1'] = $lifes ['introduct_lang1'];
            $lifeTemp ['introduct_lang2'] = $lifes ['introduct_lang2'];
            $lifeTemp ['introduct_lang3'] = $lifes ['introduct_lang3'];
            $lifeTemp ['detail_lang1'] = $lifes ['detail_lang1'];
            $lifeTemp ['detail_lang2'] = $lifes ['detail_lang2'];
            $lifeTemp ['detail_lang3'] = $lifes ['detail_lang3'];
            $lifeTemp ['lat'] = $lifes ['lat'];
            $lifeTemp ['lng'] = $lifes ['lng'];
            $lifeTemp ['status'] = $lifes ['status'];
            $lifeTemp ['tagId'] = $lifes ['typeid'];
            $lifeTemp ['tagName_lang1'] = $typeListNew [$lifeTemp ['tagId']] ['titleLang1'];
            $lifeTemp ['tagName_lang2'] = $typeListNew [$lifeTemp ['tagId']] ['titleLang2'];
            $lifeTemp ['tagName_lang3'] = $typeListNew [$lifeTemp ['tagId']] ['titleLang3'];
            $lifeTemp ['sort'] = $lifes ['sort'];
            $lifeTemp ['pdf'] = $lifes ['pdf'];
            $lifeTemp ['video'] = $lifes ['video'];
            $lifeTemp ['pic'] = $lifes ['pic'];
            $lifeTemp ['createTime'] = $lifes ['createtime'];
            $lifeTemp ['updateTime'] = $lifes ['updatetime'];
            $data ['list'] [] = $lifeTemp;
        }
        $data ['total'] = $lifeCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 雅士阁生活详情结果转换器
     *
     * @param array $lifes
     *            雅士阁生活详情
     * @return array
     */
    public function getLifeDetailConvertor($lifes) {
        $data = array();
        $data ['id'] = $lifes ['id'];
        $data ['name'] = $this->handlerMultiLang('name', $lifes);
        $data ['address'] = $this->handlerMultiLang('address', $lifes);
        $data ['tel'] = $lifes ['tel'];
        $data ['introduct'] = $this->handlerMultiLang('introduct', $lifes);
        $data ['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $lifes));
        $data ['lat'] = $lifes ['lat'];
        $data ['lng'] = $lifes ['lng'];
        $data ['createTime'] = $lifes ['createtime'];
        $data ['updateTime'] = $lifes ['updatetime'];
        $data ['status'] = $lifes ['status'];
        return $data;
    }

    /**
     * 后台雅士阁生活详情结果转换器
     *
     * @param array $lifes
     *            雅士阁生活详情
     * @return array
     */
    public function getAdminLifeDetailConvertor($lifes) {
        $data = array();
        $data ['id'] = $lifes ['id'];
        $data ['name_lang1'] = $lifes ['name_lang1'];
        $data ['name_lang2'] = $lifes ['name_lang2'];
        $data ['name_lang3'] = $lifes ['name_lang3'];
        $data ['address_lang1'] = $lifes ['address_lang1'];
        $data ['address_lang2'] = $lifes ['address_lang2'];
        $data ['address_lang3'] = $lifes ['address_lang3'];
        $data ['tel'] = $lifes ['tel'];
        $data ['introduct_lang1'] = $lifes ['introduct_lang1'];
        $data ['introduct_lang2'] = $lifes ['introduct_lang2'];
        $data ['introduct_lang3'] = $lifes ['introduct_lang3'];
        $data ['detail_lang1'] = $lifes ['detail_lang1'];
        $data ['detail_lang2'] = $lifes ['detail_lang2'];
        $data ['detail_lang3'] = $lifes ['detail_lang3'];
        $data ['lng'] = $lifes ['lng'];
        $data ['lat'] = $lifes ['lat'];
        $data ['createTime'] = $lifes ['createtime'];
        $data ['updateTime'] = $lifes ['updatetime'];
        $data ['status'] = $lifes ['status'];
        return $data;
    }
}