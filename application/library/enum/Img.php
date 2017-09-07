<?php

class Enum_Img {

    // 阿里云图片服务地址
    const OSS_IMGURL = 'https://iservice.oss-cn-beijing.aliyuncs.com';

    const PIC_TYPE_KEY_WIDTH750 = 'width_750';


    /**
     * 根据key和类型获取图片路径
     *
     * @param string $picId
     * @param
     *            int addLogo 1代表添加，0代表不添加
     * @return string|multitype:string
     */
    public static function getPathByKeyAndType($picId, $imgType = "") {
        $url = '';
        if (!empty($picId)) {
            $picId = str_replace(array(
                "_",
                "//"
            ), "/", $picId);
            $picIdIndex = $picId[0];
            $idel = $picIdIndex == '/' ? '' : '/';
            $url = self::OSS_IMGURL . $idel . $picId . ($imgType ? '!' . $imgType : '');
        }
        return $url;
    }

    /**
     * 获取图片上传路径以及图片id
     *
     * @param string $fileName
     *            const PARAM_IMG_BPIC = 'bPic';
     *            const PARAM_IMG_MPIC = 'mPic';
     *            const PARAM_IMG_SPIC = 'sPic';
     * @return multitype:string
     */
    public static function getPicNameAndKey($fileName, $filePath = "") {
        $data = array();
        if ($fileName) {
            $fileName = strtolower($fileName);
            $tmp = explode('.', $fileName);
            $fileKey = $filePath ? $filePath . '_' : '';
            $filePath = $filePath ? $filePath . '/' : '';
            if (count($tmp) > 1) {
                $rand = md5(time() . mt_rand(1111, 9999));
                $data['fileName'] = 'iservicev2/' . $filePath . date('Ym') . '/' . $rand . '.' . end($tmp);
                $data['key'] = 'iservicev2_' . $fileKey . date('Ym') . '_' . $rand . '.' . end($tmp);
            }
        }
        return $data;
    }


}
