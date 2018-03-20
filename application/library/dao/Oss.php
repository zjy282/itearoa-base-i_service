<?php

/**
 * OSS数据层
 */
class Dao_Oss extends \Dao_Base {
    private $oss;

    public function __construct() {
        //todo Get oss info from config
        $this->oss = new Oss_Ali();
    }

    /**
     * 上传文件至OSS
     * @param $bucket
     * @param array $imgInfo
     * @param $filePath
     * @return mixed|string
     */
    public function uploadImg($bucket, array $imgInfo, $filePath) {
        $picId = '';
        if ($bucket && $imgInfo['fileName'] && $filePath) {
            $response = $this->oss->upload_file_by_file($bucket, $imgInfo['fileName'], $filePath);
            //print_r($response);exit;
            if ($response->status == 200) {
                $picId = $imgInfo['key'];
            }
        }
        return $picId;
    }

    /**
     * Delete file from oss
     *
     * @param $bucket
     * @param $object
     * @return bool
     * @throws Exception
     * @throws OSS_Exception
     */
    public function deleteFile($bucket, $object)
    {
        $exist = $this->oss->is_object_exist($bucket, $object);
        if ($exist->isOK()) {
            $response = $this->oss->delete_object($bucket, $object);
            return $response->isOK();
        } else {
            throw new Exception($object . ' not exist');
        }
    }

}

?>