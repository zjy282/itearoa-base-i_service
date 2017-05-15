<?php

/**
 * Class TranslateModel
 * 翻译Model
 */
class TranslateModel extends \BaseModel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 执行翻译
     * @param $param
     * @return mixed
     */
    public function translate($param) {
        if (empty($param['keyword']) || empty($param['from']) || empty($param['to'])) {
            $this->throwException('入参数错误', 2);
        }

        $translateList = Enum_Translate::translateList();
        if (!$translateList[$param['from']]) {
            $this->throwException($param['from'] . '不在支持的语言列表', 3);
        }
        if (!$translateList[$param['to']]) {
            $this->throwException($param['to'] . '不在支持的语言列表', 3);
        }

        $translateUrl = Enum_Translate::getTranslateUrl($param['keyword'], $param['from'], $param['to']);
        $translateResult = Util_Http::fileGetContentsWithTimeOut($translateUrl);
        $result = json_decode($translateResult, true);
        if ($result['error_code']) {
            $this->throwException('翻译失败', 4);
        }
        return $result;
    }
}
