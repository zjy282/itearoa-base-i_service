<?php

/**
 * 体验购物convertor
 * @author ZXM
 */
class Convertor_Shopping extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    public function getShoppingListConvertor($shoppingList, $tagList, $shoppingCount, $param) {
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
}