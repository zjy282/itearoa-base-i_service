<?php

class Enum_Img {
    
    // 阿里云图片服务地址
    const OSS_IMGURL = 'https://ypimg1.youpu.cn';

    const APP_INDEX_LIST_V1 = 'app_index_list';

    const TOPX_LIST_V1 = 'top_list_v1';

    const INDEX_LIST_B_V1 = 'index_list_b';

    const INDEX_LIST_M_V1 = 'index_list_m';

    const INDEX_LIST_S_V1 = 'index_list_s';

    const USER_ICON_S_V1 = 'user_icon_s';

    const CITY_LIST_R_V1 = 'city_list_r';

    const SH_LIST_ZOOM = 'sh_list_zoom';

    const SH_DETAIL_ZOOM = 'sh_detail_zoom';

    const DEST_DETAIL = 'dest_detail_m';

    const INDEX_COUNTRY_BG = 'index_country_bg';

    const LEVEL_ZOOM_C = 1;

    const LEVEL_ZOOM_W = 2;

    const LEVEL_ZOOM_H = 3;

    const LEVEL_ZOOM_WH = 4;

    const PLACE_INDEX_R_V1 = 'place_list_r';
    // 新版国家、城市首页
    private static $imgType = array(
        self::APP_INDEX_LIST_V1 => 'bPic',
        self::TOPX_LIST_V1 => 'bPic',
        self::INDEX_LIST_B_V1 => 'bPic',
        self::CITY_LIST_R_V1 => 'bPic',
        self::SH_LIST_ZOOM => 'bPic',
        self::SH_DETAIL_ZOOM => 'bPic',
        self::PLACE_INDEX_R_V1 => 'bPic',
        self::INDEX_LIST_M_V1 => 'mPic',
        self::INDEX_LIST_S_V1 => 'sPic',
        self::USER_ICON_S_V1 => 'sPic',
        self::DEST_DETAIL => 'mPic',
        self::INDEX_COUNTRY_BG => 'bgPic'
    );

    /**
     *
     * @param
     *            array();
     *            w代表宽，h代表高，a代表是否自动裁切（c代表自动裁切），b代表缩放优先级（e代表短边优先）
     */
    private static $defaultImgSize = array(
        self::APP_INDEX_LIST_V1 => array(
            'w' => '640',
            'h' => '430',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::CITY_LIST_R_V1 => array(
            'w' => '320',
            'h' => '426',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::PLACE_INDEX_R_V1 => array(
            'w' => '640',
            'h' => '1000',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::INDEX_LIST_M_V1 => array(
            'w' => '300',
            'h' => '300',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::INDEX_LIST_S_V1 => array(
            'w' => '160',
            'h' => '160',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::INDEX_LIST_B_V1 => array(
            'w' => '600',
            'h' => '600',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::TOPX_LIST_V1 => array(
            'w' => '640',
            'h' => '640',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::USER_ICON_S_V1 => array(
            'w' => '300',
            'h' => '300',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::SH_LIST_ZOOM => array(
            'w' => '1080',
            'o' => '1o'
        ),
        self::SH_DETAIL_ZOOM => array(
            'w' => '1080',
            'o' => '1o'
        ),
        self::DEST_DETAIL => array(
            'w' => '560',
            'h' => '280',
            'a' => '1c',
            'b' => '1e',
            'o' => '1o'
        ),
        self::INDEX_COUNTRY_BG => array(
            'w' => '800',
            'h' => '1280'
        )
    );

    /**
     * 根据Enum_Img key获取
     *
     * @param string $key            
     * @param
     *            int addLogo 1代表添加，0代表不添加
     * @return multitype:multitype:string
     */
    public static function getImgSizeKey($key, $addLogo = 0) {
        $data = self::$defaultImgSize[$key];
        $result = '';
        if (is_array($data)) {
            $w = $data['w'];
            $h = $data['h'];
            $ypImg = Sys_YpVersion::getInstance()->getConfig(Enum_Version::PARAM_IMG);
            $size = isset($ypImg[self::$imgType[$key]]) ? $ypImg[self::$imgType[$key]] : array();
            if (isset($data['a'])) { // 判断是否是裁切
                if ($size['w'] > 0 && $size['h'] > 0) {
                    $w = $size['w'];
                    $h = $size['h'];
                }
            } else {
                self::issetImgData($w, $data, $size, 'w');
                self::issetImgData($h, $data, $size, 'h');
            }
            
            if (isset($data['w']) && $w) {
                $data['w'] = $w . 'w';
            }
            
            if (isset($data['h']) && $h) {
                $data['h'] = $h . 'h';
            }
            // $size['c'] = 10;
            $c = intval($size['c']);
            if ($c) {
                $data['c'] = $c . '-2ci';
            }
            $data = array_filter($data);
            $result = '@' . implode('_', $data);
            $result = $addLogo ? $result . '|' . self::getWaterLogo() : $result;
        }
        return $result;
    }

    /**
     * 判断是否存在，存在则对引用进行赋值
     *
     * @param string $value
     *            需要修改的变量，需要是引用
     * @param string $data
     *            判断的值
     * @param string $size
     *            header中获取的值
     * @param string $key
     *            key
     */
    private static function issetImgData(&$value, $data, $size, $key) {
        if (isset($data[$key])) {
            $value = $size[$key] ? $size[$key] : $value;
        }
    }

    /**
     * P参数代表：水印图片按主图的比例进行处理 10代表10%
     * x水平边距
     * y垂直边距
     * object 是水印图片名称进行base64编码 waterlogo.png
     */
    private static function getWaterLogo() {
        $imgParam = 'watermark=1&object=d2F0ZXJsb2dvLnBuZw==&P=9&x=10&y=10';
        return $imgParam;
    }

    /**
     * 根据key和类型获取图片路径
     *
     * @param string $picId            
     * @param
     *            int addLogo 1代表添加，0代表不添加
     * @return string|multitype:string
     */
    public static function getPathByKeyAndType($picId, $imgType = "", $addLogo = 0) {
        $url = '';
        if (! empty($picId)) {
            $picId = str_replace(array(
                "_",
                "//"
            ), "/", $picId);
            $picIdIndex = $picId[0];
            $idel = $picIdIndex == '/' ? '' : '/';
            $url = self::OSS_IMGURL . $idel . $picId . self::getImgSizeKey($imgType);
            $url = $addLogo ? $url . '@' . self::getWaterLogo() : $url;
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
                $data['fileName'] = 'yp/' . $filePath . date('Ym') . '/' . date('d') . '/' . $rand . '.' . end($tmp);
                $data['key'] = 'yp_' . $fileKey . date('Ym') . '_' . date('d') . '_' . $rand . '.' . end($tmp);
            }
        }
        return $data;
    }

    public static function allowExtension() {
        return array(
            'image/bmp' => 'bmp',
            'image/gif' => 'gif',
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        );
    }

    /**
     * 获取图片全路径
     *
     * @author 张振宇
     * @param string $key
     *            图片key
     * @param number $isStorage
     *            0：旧的图片地址；1：阿里云图片服务地址
     * @param string $path
     *            数据库图片有带/和不带/两种
     * @param int $type
     *            是否使用OSS图片域名
     * @param int $size
     *            0原图，1首页长方形640*430，2大方图600*600，3列表小图300*300，4列表小图160*160
     *            
     * @return string 图片全路径
     */
    public static function getPathByKey($key, $isStorage = 0, $virgule = '', $size = 1, $type = 0) {
        $path = '';
        if ($key) {
            if ($isStorage) {
                $path = self::OSS_IMGURL . '/' . str_replace('_', '/', $key);
            } else {
                if ($type == 0) {
                    $key = str_replace("//", "/", $key);
                    $path = self::OSS_IMGURL . '/' . str_replace('_', '/', $key);
                } else {
                    $path = self::YP_IMGURL . $virgule . $key;
                }
            }
        }
        return $path;
    }

    /**
     * 图片列表-所有
     */
    const PIC_LIST = "pic_list_all";

    /**
     * 图片列表-后台上传
     */
    const PIC_LIST_OFFICIAL = "pic_list_official";

    /**
     * 图片列表-shine图被标识录用
     */
    const PIC_LIST_SHINE = "pic_list_shine";

    /**
     * 图片单张-后台推荐
     */
    const PIC_ONE_RECOMMEND = "pic_one_recommend";

    /**
     * 图片单张-后台推荐
     */
    const PIC_ONE_RECOMMEND_OFFICIAL = "pic_one_recommend_official";

    /**
     * 列表默认获取的图片数量
     */
    const PIC_DEFAULT_COUNT = 10;

    /**
     * 获取poi图片的配置
     *
     * @param string $type            
     * @return multitype:boolean string number
     */
    public static function getPicConfig($configId, $count = 10) {
        $count = empty($count) ? self::PIC_DEFAULT_COUNT : $count;
        $config = array(
            "count" => $count, // 获取几张
            "recommend" => false, // 是否获取推荐
            "showOfficial" => true, // 是从yp_pic表获取
            "showShine" => true, // 是否从晒图获取
            'sort' => 'update'
        ); // 按照更新时间排序
        
        switch ($configId) {
            case self::PIC_LIST_OFFICIAL:
                $config['showShine'] = false;
                break;
            case self::PIC_LIST_SHINE:
                $config['showOfficial'] = false;
                break;
            case self::PIC_ONE_RECOMMEND:
                $config['count'] = 1;
                $config['recommend'] = true;
                break;
            case self::PIC_ONE_RECOMMEND_OFFICIAL:
                $config['count'] = 1;
                $config['recommend'] = true;
                $config['showShine'] = false;
                break;
        }
        return $config;
    }
}
