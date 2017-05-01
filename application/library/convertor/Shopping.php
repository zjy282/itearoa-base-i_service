<?php

/**
 * 体验购物convertor
 * @author ZXM
 */
class Convertor_Shopping extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getEffectiveShoppingListConvertor($shoppingList, $tagList, $shoppingCount, $param) {
        $tagListNew = array();
        foreach ($tagList as $tag) {
            $tagListNew[$tag['id']] = $this->handlerMultiLang('title', $tag);
        }

        $data = array(
            'list' => array()
        );
        foreach ($shoppingList as $shopping) {
            $shoppingTemp = array();
            $shoppingTemp['id'] = $shopping['id'];
            $shoppingTemp['title'] = $this->handlerMultiLang('title', $shopping);
            $shoppingTemp['introduct'] = $this->handlerMultiLang('introduct', $shopping);
            $shoppingTemp['detail'] = Enum_Img::getPathByKeyAndType($this->handlerMultiLang('detail', $shopping));
            $shoppingTemp['pic'] = Enum_Img::getPathByKeyAndType($shopping['pic']);
            $shoppingTemp['tagId'] = $shopping['tagid'];
            $shoppingTemp['tagName'] = $tagListNew[$shoppingTemp['tagId']];
            $shoppingTemp['createtime'] = $shopping['createtime'];
            $shoppingTemp['updatetime'] = $shopping['updatetime'];
            $data['list'][] = $shoppingTemp;
        }
        $data['total'] = $shoppingCount;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }

    public function getShoppingListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        $hotelIdlist = array_column($list, 'hotelid');
        $hotelModel = new HotelListModel();
        $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdlist));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');

        $tagidList = array_column($list, 'tagid');
        if ($tagidList) {
            $shoppingTagModel = new ShoppingTagModel();
            $shoppingTagList = $shoppingTagModel->getshoppingTagList(array('id' => $tagidList));
            $shoppingTagNameList = array_column($shoppingTagList, 'title_lang1', 'id');
        }

        foreach ($list as $key => $value) {
            $shoppingTemp = array();
            $shoppingTemp['id'] = $value['id'];
            $shoppingTemp['title_lang1'] = $value['title_lang1'];
            $shoppingTemp['title_lang2'] = $value['title_lang2'];
            $shoppingTemp['title_lang3'] = $value['title_lang3'];
            $shoppingTemp['introduct_lang1'] = $value['introduct_lang1'];
            $shoppingTemp['introduct_lang2'] = $value['introduct_lang2'];
            $shoppingTemp['introduct_lang3'] = $value['introduct_lang3'];
            $shoppingTemp['detail_lang1'] = $value['detail_lang1'];
            $shoppingTemp['detail_lang2'] = $value['detail_lang2'];
            $shoppingTemp['detail_lang3'] = $value['detail_lang3'];
            $shoppingTemp['hotelid'] = $value['hotelid'];
            $shoppingTemp['hotelName'] = $hotelNameList[$shoppingTemp['hotelid']];
            $shoppingTemp['pic'] = $value['pic'];
            $shoppingTemp['createtime'] = $value['createtime'];
            $shoppingTemp['tagid'] = $value['tagid'];
            $shoppingTemp['tagName'] = $shoppingTagNameList[$shoppingTemp['tagid']];
            $data['list'][] = $shoppingTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }
}