<?php

/**
 * 语言类型枚举
 * @author ZXM
 */
class Enum_Lang
{

    const CHINESE = 'zh';
    const ENGLISH = 'en';
    const JAPANESE = 'jp';
    const KOREAN = 'kor';

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
     * Language index dictionary
     *
     * @var array
     */
    private static $_langIndexList = array(
        self::CHINESE => 1,
        self::ENGLISH => 2,
        self::JAPANESE => 3,
        self::KOREAN => 4,
    );

    /**
     * 获取语言类型名称字典
     *
     * @return array
     */
    public static function getLangNameList()
    {
        return self::$langNameList;
    }

    public static function getLangIndexList()
    {
        return self::$_langIndexList;
    }

    /**
     * 获取酒店语言列表cache key
     *
     * @param int $hotelId
     *            物业Id
     * @return string
     */
    public static function getHotelLangListCacheKey($hotelId)
    {
        return 'hotel_lang_list_' . $hotelId . '_v1';
    }

    /**
     * @param string $lang
     * @param string $default
     * @return int
     */
    public static function getLangIndex(string $lang, string $default = self::ENGLISH): int
    {
        if (!in_array($lang, array_keys(self::$_langIndexList))) {
            $lang = $default;
        }
        return self::$_langIndexList[$lang];
    }
}

?>