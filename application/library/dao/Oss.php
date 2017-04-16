<?php
class Dao_Oss extends \Dao_Base {
    private $oss;
    public function __construct(){
        $this->oss = new Oss_Ali();
    }

    public function uploadImg($bucket,array $imgInfo,$filePath){
        $picId = '';
        if ($bucket && $imgInfo['fileName'] && $filePath){
            $response = $this->oss->upload_file_by_file($bucket,$imgInfo['fileName'],$filePath);
            //print_r($response);exit;
            if ($response->status == 200){
                $picId = $imgInfo['key'];
            }
        }
        return $picId;
    }
}

?>