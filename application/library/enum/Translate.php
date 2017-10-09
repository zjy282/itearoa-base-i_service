<?php

class Enum_Translate {

    /**
     * 在线翻译地址
     *
     * @var string
     */
    const TRANSLATE_URL = 'http://api.fanyi.baidu.com/api/trans/vip/translate';

    /**
     * 在线翻译key
     *
     * @var string
     */
    const TRANSLATE_CLIENT_APPID = '20160126000009408';

    /**
     * 在线翻译密匙
     *
     * @var string
     */
    const TRANSLATE_CLIENT_SECKEY = 'JoObJhxSaErJsR4s1Rhc';

    /**
     * 获取翻译api地址
     *
     * @param string $keyword            
     * @param string $from            
     * @param string $to            
     * @return string
     */
    public static function getTranslateUrl($keyword, $from, $to) {
        $salt = time();
        $sign = md5(self::TRANSLATE_CLIENT_APPID . $keyword . $salt . self::TRANSLATE_CLIENT_SECKEY);
        $urlParam = array(
            'appid' => self::TRANSLATE_CLIENT_APPID,
            'q' => $keyword,
            'from' => $from,
            'to' => $to,
            'sign' => $sign,
            'salt' => $salt
        );
        $urlParam = http_build_query($urlParam);
        $url = self::TRANSLATE_URL . "?" . $urlParam;
        return $url;
    }

    private static $translateList = array(
        'zh' => '中文',
        'en' => 'English',
        'jp' => '日本語',
        'fra' => 'Français',
        'de' => 'Deutsch',
        'kor' => '한국어',
        'ru' => 'русский язык',
        'it' => 'In Italiano',
        'th' => 'ภาษาไทย',
        'spa' => 'El español',
        'ara' => ' عربي',
        'pt' => 'Português'
    );

    /**
     * 翻译简称中文对照表
     *
     * @return multitype:multitype:string
     */
    public static function translateList() {
        return self::$translateList;
    }
}
?>