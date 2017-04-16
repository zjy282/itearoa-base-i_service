<?php

class OssModel extends \BaseModel {

    public function __construct() {
        parent::__construct();
    }

    public function uploadToOss($uploadFile) {
        $uploadName = $uploadFile['name'];
        $filePath = $uploadFile['tmp_name'];
        if (empty($filePath)) {
            $this->throwException('文件不能为空', 2);
        }

        $nameList = explode(".", $uploadName);
        $extension = strtolower(end($nameList)); // 上传文件后缀名
        $allowType = Enum_Img::allowExtension();
        if (!in_array($extension, $allowType)) {
            $this->throwException("图片格式错误,允许格式:" . implode(',', $allowType), 3);
        }

        $ossDao = new Dao_Oss();
        $imgData = Enum_Img::getPicNameAndKey($uploadName);
        if ($imgData['fileName'] && $filePath) {
            $picId = $ossDao->uploadImg(Enum_Oss::OBJ_NAME_SHINE, $imgData, $filePath);
        }
        if ($picId) {
            return array(
                "picKey" => $picId
            );
        } else {
            $this->throwException('上传失败', 4);
        }
    }
}