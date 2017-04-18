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

    /**
     * 上传文件到OSS
     */
    public function uploadToOssAction() {
        $param = array();
        $param['type'] = trim($this->getParamList('type'));
        $param['uploadfile'] = $_FILES['uploadfile'];
        $ossModel = new OssModel();
        $result = $ossModel->uploadToOss($param);
        $this->echoSuccessData($result);
    }

    /**
     * 获取上传允许的文件类型
     */
    public function getAllowUploadFileTypeAction() {
        $param = array();
        $type = trim($this->getParamList('type'));
        $this->echoSuccessData(array('list' => Enum_Oss::allowExtension($type)));
    }
}
