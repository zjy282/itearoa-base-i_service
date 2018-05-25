<?php

/**
 * 体验购物转换器
 */
class Convertor_Shopping extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 可用的体验购物列表
     *
     * @param array $shoppingList
     *            可用的体验购物
     * @param array $tagList
     *            体验购物标签
     * @param int $shoppingCount
     *            可用的体验购物总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getEffectiveShoppingListConvertor($shoppingList, $tagList, $shoppingCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew [$tag ['id']] = $this->handlerMultiLang('title', $tag);
        }
        $data = array('list' => array());
        foreach ($shoppingList as $shopping) {
            $shoppingTemp = array();
            $shoppingTemp['id'] = $shopping['id'];
            $shoppingTemp['title'] = $this->handlerMultiLang('title', $shopping);
            $shoppingTemp['title_lang1'] = $shopping['title_lang1'];
            $shoppingTemp['title_lang2'] = $shopping['title_lang2'];
            $shoppingTemp['title_lang3'] = $shopping['title_lang3'];
            $shoppingTemp['introduct'] = $this->handlerMultiLang('introduct', $shopping);
            $shoppingTemp['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $shopping));
            $shoppingTemp['pic'] = Enum_Img::getPathByKeyAndType($shopping['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750);
            $shoppingTemp['pdf'] = $shopping['pdf'] ? Enum_Img::getPathByKeyAndType($shopping['pdf']) : '';
            $shoppingTemp['video'] = $shopping['video'] ? Enum_Img::getPathByKeyAndType($shopping['video']) : '';
            $shoppingTemp['tagId'] = $shopping['tagid'];
            $shoppingTemp['price'] = $shopping['price'];
            $shoppingTemp['tagName'] = $tagListNew[$shoppingTemp ['tagId']];
            $shoppingTemp['createtime'] = $shopping['createtime'];
            $shoppingTemp['updatetime'] = $shopping['updatetime'];
            $data ['list'] [] = $shoppingTemp;
        }
        $data ['total'] = $shoppingCount;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 体验购物列表
     *
     * @param array $list
     *            体验购物列表
     * @param int $count
     *            体验购物总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getShoppingListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $hotelIdlist = array_column($list, 'hotelid');
        $hotelModel = new HotelListModel ();
        $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdlist));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');
        $tagidList = array_column($list, 'tagid');
        if ($tagidList) {
            $shoppingTagModel = new ShoppingTagModel ();
            $shoppingTagList = $shoppingTagModel->getshoppingTagList(array('hotelid' => $hotelIdlist[0]));
            $shoppingTagNameList = array_column($shoppingTagList, 'title_lang1', 'id');
        }
        foreach ($list as $key => $value) {
            $shoppingTemp = array();
            $shoppingTemp ['id'] = $value ['id'];
            $shoppingTemp ['title_lang1'] = $value ['title_lang1'];
            $shoppingTemp ['title_lang2'] = $value ['title_lang2'];
            $shoppingTemp ['title_lang3'] = $value ['title_lang3'];
            $shoppingTemp ['introduct_lang1'] = $value ['introduct_lang1'];
            $shoppingTemp ['introduct_lang2'] = $value ['introduct_lang2'];
            $shoppingTemp ['introduct_lang3'] = $value ['introduct_lang3'];
            $shoppingTemp ['detail_lang1'] = $value ['detail_lang1'];
            $shoppingTemp ['detail_lang2'] = $value ['detail_lang2'];
            $shoppingTemp ['detail_lang3'] = $value ['detail_lang3'];
            $shoppingTemp ['price'] = $value ['price'];
            $shoppingTemp ['hotelid'] = $value ['hotelid'];
            $shoppingTemp ['hotelName'] = $hotelNameList [$shoppingTemp ['hotelid']];
            $shoppingTemp ['pic'] = $value ['pic'];
            $shoppingTemp ['createtime'] = $value ['createtime'];
            $shoppingTemp ['sort'] = $value ['sort'];
            $shoppingTemp ['pdf'] = $value ['pdf'];
            $shoppingTemp ['video'] = $value ['video'];
            $shoppingTemp ['tagid'] = $value ['tagid'];
            $shoppingTemp ['tagName'] = $shoppingTagNameList [$shoppingTemp ['tagid']];
            $shoppingTemp ['status'] = $value ['status'];
            $data ['list'] [] = $shoppingTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }
}
