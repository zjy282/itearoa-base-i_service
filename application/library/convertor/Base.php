<?php

class Convertor_Base {

    public function __construct() {
    }

    public function commonConvertor(array $result) {
        $data = array();
        $data['code'] = $result['code'];
        if (isset($result['code']) && ! $result['code']) {
            $data['data'] = $result['data'];
        } else {
            $data['code'] = empty($result['code']) ? 1 : $result['code'];
            $data['msg'] = $result['msg'];
        }
        return $data;
    }

    /**
     * 用于update和insert的数据转换器
     *
     * @param array|bool $result
     *            当$result 为数组时 必须有id key-vaule 否则是否insert失败
     * @return array | exception
     */
    public function statusConvertor($result) {
        $data = array();
        if (! $result || (is_array($result) && ! $result['id'])) {
            $this->throwException('1', '操作失败');
        } elseif (is_array($result)) {
            $data['id'] = $result['id'];
        }
        return $data;
    }

    /**
     * 抛出异常
     *
     * @param string $code            
     * @param string $msg            
     * @throws Exception
     */
    protected function throwException($code, $msg) {
        throw new Exception($msg, $code);
    }

    /**
     * 获取多语言数据
     *
     * @param string $dataKey
     *            数据xxx_langx中的_前半部分
     * @param array $data
     *            包含三种语言的数据数组
     * @return string 对应访问语言的数据
     */
    protected function handlerMultiLang($dataKey, $data) {
        $langInfo = Yaf_Registry::get('hotelLangInfo');
        
        $dataLangKey = $dataKey . '_lang' . $langInfo['langIndex'];
        $value = $data[$dataLangKey] ? $data[$dataLangKey] : $data[$dataKey . '_lang1'];
        return $value;
    }

    /**
     * Get lang config from parameter lang
     *
     * @param bool $isIndex
     * @return int
     */
    public static function getLang($isIndex = true)
    {
        $result = Yaf_Registry::get('hotelLangInfo');
        $index = $result['langIndex'];
        if (!$index) {
            $index = 1;
        }
        $result = $index;

        if (!$isIndex) {
            $array = array_flip(Enum_Lang::getLangIndexList());
            $result = $array[$result];
        }
        return $result;
    }
}
