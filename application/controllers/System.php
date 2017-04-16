<?php

class SystemController extends \BaseController {

    public function init() {
        parent::init();
    }

    /**
     * 获取服务器时间
     */
    public function getTimeAction() {
        $this->echoSuccessData(array(
            'time' => time()
        ));
    }

    /**
     * 获取系统支持的语言列表
     */
    public function getLanguageListAction() {
        $this->echoSuccessData(array('list' => Enum_Lang::getLangNameList()));
    }

    public function uploadToOssAction() {
        $uploadFile = $_FILES['uploadfile'];
        $ossModel = new OssModel();
        $result = $ossModel->uploadToOss($uploadFile);
        $this->echoSuccessData($result);
    }
}
