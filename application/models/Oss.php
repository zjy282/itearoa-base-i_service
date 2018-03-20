<?php

/**
 * Class OssModel
 * OSS管理Model
 */
class OssModel extends \BaseModel {

    private $_daoOss;

    public function __construct() {
        parent::__construct();
        $this->_daoOss = new Dao_Oss();
    }

    /**
     * 上传至OSS
     * @param $paramList
     * @return array||void
     */
    public function uploadToOss($paramList) {
        $oldfilekey = $paramList['oldfilekey'];
        $uploadFile = $paramList['uploadfile'];
        $fileType = $paramList['type'];
        $uploadName = $uploadFile['name'];
        $filePath = $uploadFile['tmp_name'];
        if (empty($filePath)) {
            $this->throwException('文件不能为空', 2);
        }
        if (empty($fileType)) {
            $this->throwException('文件类型不能为空', 2);
        }

        $nameList = explode(".", $uploadName);
        $extension = strtolower(end($nameList)); // 上传文件后缀名
        $allowType = Enum_Oss::allowExtension($fileType);
        if (!in_array($extension, $allowType)) {
            $this->throwException("格式错误,允许格式:" . implode(',', $allowType), 3);
        }

        if ($oldfilekey) {
            $imgData = array('fileName' => str_replace('_', '/', $oldfilekey), 'key' => $oldfilekey);
        } else {
            $imgData = Enum_Img::getPicNameAndKey($uploadName, $fileType);
        }
        if ($imgData['fileName'] && $filePath) {
            $picId = $this->_daoOss->uploadImg(Enum_Oss::OBJ_NAME_SHINE, $imgData, $filePath);
        }
        if ($picId) {
            return array(
                "picKey" => $picId
            );
        } else {
            $this->throwException('上传失败', 4);
        }
    }

    /**
     * @param $fileKey
     * @throws Exception
     * @throws OSS_Exception
     * @return bool
     */
    public function deleteFromOss($fileKey) {
        $filePath = str_replace('_', '/', $fileKey);
        $result = $this->_daoOss->deleteFile(Enum_Oss::OBJ_NAME_SHINE, $filePath);
        return boolval($result);
    }
}