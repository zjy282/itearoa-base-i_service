<?php

/**
 * Class Convertor_Sign
 */
class Convertor_Sign extends Convertor_Base
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $list
     * @param $count
     * @param $param
     * @return array
     */
    public function getSignListConvertor($list, $count, $param)
    {
        $data = array('list' => $list);
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }


    public function getSignCategoryListConvertor($list, $count, $param)
    {
        $copy = $list;
        foreach ($copy as &$item) {
            $item['pic'] = Enum_Img::getPathByKeyAndType($item['pic']);
        }
        $data = array('list' => $copy);
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    public function getSignItemListConvertor($list, $categories, $count, $param)
    {
        $copy = $list;
        foreach ($copy as &$item) {
            foreach ($categories as $category) {
                if ($category['id'] == $item['category_id']) {
                    $item['category_name1'] = $category['title_lang1'];
                    $item['category_name2'] = $category['title_lang2'];
                    $item['category_name3'] = $category['title_lang3'];
                    break;
                }
            }
        }
        $data = array('list' => $copy);
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

}