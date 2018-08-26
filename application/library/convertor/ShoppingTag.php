<?php

/**
 * 体验购物标签转换器
 */
class Convertor_ShoppingTag extends Convertor_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 体验购物标签数据转换器
     *
     * @param array $list
     *            体验购物标签
     * @param int $count
     *            体验购物标签总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getShoppingTagListConvertor($list, $param) {
        $data = array('list' => array());
        $hotelIdList = $hotelIdList = array_unique(array_column($list['data'], 'hotelid'));
        $hotelModel = new HotelListModel ();
        $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdList));
        $hotelNameList = array_column($hotelInfoList, 'name_lang1', 'id');

        if ($param['limit'] > 0) {
            $dataArray = $list['data'];
        } else {
            $dataArray = $list;
        }
        foreach ($dataArray as $value) {
            $oneTemp = array();
            $oneTemp ['id'] = $value ['id'];
            $oneTemp ['title'] = $this->handlerMultiLang('title', $value);
            $oneTemp['title_lang1'] = $value['title_lang1'];
            $oneTemp['title_lang2'] = $value['title_lang2'];
            $oneTemp['title_lang3'] = $value['title_lang3'];
            $oneTemp['pic'] = Enum_Img::getPathByKeyAndType($value['pic']);
            $oneTemp ['hotelId'] = $value ['hotelid'];
            $oneTemp ['hotelName'] = $hotelNameList [$value ['hotelid']];
            $oneTemp['parentid'] = $value['parentid'];
            $oneTemp['staff_list'] = explode(Enum_System::COMMA_SEPARATOR, $value['staff_list']);
            $oneTemp['status'] = $value['status'];
            $oneTemp['is_robot'] = $value['is_robot'];
            if ($param['withChild']) {
                $oneTemp['children'] = array();
                foreach ($value['children'] as $child) {
                    $child['pic'] = Enum_Img::getPathByKeyAndType($child['pic']);
                    array_push($oneTemp['children'], $child);
                }
            }
            $data ['list'] [] = $oneTemp;
        }
        $data ['total'] = $list['total'];
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * Parse img url
     *
     * @param $list
     * @return mixed
     */
    public function getShoppingTagDetailConvertor($list)
    {
        $result = $list;
        $result['pic'] = Enum_Img::getPathByKeyAndType($list['pic']);
        foreach ($result['children'] as &$child) {
            $child['pic'] = Enum_Img::getPathByKeyAndType($child['pic']);
        }
        return $result;
    }
}
