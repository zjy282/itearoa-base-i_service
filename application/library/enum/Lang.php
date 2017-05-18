<?php

/**
 * 语言类型枚举
 * @author ZXM
 */
class Enum_Lang {

    /**
     * 语言类型名称字典 array
     */
    private static $langNameList = array(
        'zh' => '中文',
        'en' => '英文',
        'jp' => '日语',
        'kor' => '韩语'
    );

    /**
     * 获取语言类型名称字典
     *
     * @return array
     */
    public static function getLangNameList() {
        return self::$langNameList;
    }

    /**
     * 获取酒店语言列表cache key
     *
     * @param int $hotelId
     *            物业Id
     * @return string
     */
    public static function getHotelLangListCacheKey($hotelId) {
        return 'hotel_lang_list_' . $hotelId . '_v1';
    }
}

?>