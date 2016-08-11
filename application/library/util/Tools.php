<?php

class Util_Tools {

    /**
     *
     * @param unknown $url            
     */
    public static function redirect302($url) {
        header("HTTP/1.1 302 Found");
        header("Location: " . $url);
        exit();
    }

    public static function getRandChar($length, $num = 1) {
        $str = null;
        $strPol = "0123456789";
        $max = strlen($strPol) - 1;
        
        for ($i = 0; $i < $length; $i ++) {
            $str .= $strPol[rand(0, $max)];
        }
        if ($num == 1)
            return $str;
        else {
            for ($i = 0; $i < $num; $i ++) {
                $charArr[] = self::getRandChar($length);
            }
            return $charArr;
        }
    }
    
    // 把秒转换成"1小时50分"的格式
    public static function secondTimeToStr($iTime) {
        $minites = abs($iTime) / 60;
        if (floor($minites / 60) == 0) {
            $sTime = $minites . "分钟";
        } else {
            $sTime = floor($minites / 60) . "小时";
            if ($minites % 60 != 0) {
                $sTime .= ($minites % 60) . "分";
            }
        }
        return $sTime;
    }

    /**
     * 检查请求是否合法，如果非法则拒绝请求且关闭当前窗口
     */
    public static function validateRequest() {
        // 获取发起请求的页面地址
        $referer = empty($_SERVER["HTTP_REFERER"]) ? "" : trim($_SERVER["HTTP_REFERER"]);
        
        // 获取当前页面的域名
        $pattern = "/" . preg_quote($_SERVER['SERVER_NAME']) . "/i";
        
        if (empty($referer) || ! preg_match($pattern, $referer, $matches)) {
            // $this->alertAndClose("错误：非法URL提交页面！");
            return false;
        }
        return true;
    }

    /**
     * 弹出提示窗口
     *
     * @param string $msg
     *            提示的信息
     */
    public static function alert($msg) {
        if (! empty($msg)) {
            $script = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
            $script .= "<script type='text/javascript'>\n";
            $script .= "alert('" . trim($msg) . "');\n";
            $script .= "</script>\n";
            echo $script;
        }
        exit();
    }

    /**
     * 弹出并返回
     *
     * @param string $msg
     *            提示的信息
     */
    public static function alertAndGoBack($msg) {
        if (! empty($msg)) {
            $script = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
            $script .= "<script type='text/javascript'>\n";
            $script .= "alert('" . trim($msg) . "');\n";
            $script .= "history.go(-1);";
            $script .= "</script>\n";
            echo $script;
        }
        exit();
    }

    /**
     * 在页面上弹出提示窗口，用户点击确定后，页面自动跳转到指定的页面
     *
     * @param string $msg
     *            提示的信息
     * @param string $url
     *            跳转的页面地址
     * @param string $top
     *            跳出框架
     */
    public static function alertAndRedirect($msg, $url, $top = '') {
        if (! empty($msg) || ! empty($url)) {
            $script = "<HTML><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><body>";
            $script .= "<script type='text/javascript'>\n";
            if (! empty($msg)) {
                $script .= "alert('" . trim($msg) . "');\n";
            }
            $script .= $top . "location.href='" . trim($url) . "';";
            $script .= "</script>\n</body></HTML>";
            echo $script;
        }
        exit();
    }

    /**
     * 通过输出script跳转到指定的页面
     *
     * @param string $url
     *            跳转的页面地址
     */
    public static function scriptRedirect($url) {
        if (! empty($url)) {
            $script = "<HTML><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><body>";
            $script .= "<script type='text/javascript'>\n";
            $script .= " location.href='" . trim($url) . "';";
            $script .= "</script>\n</body></HTML>";
            echo $script;
        }
        exit();
    }

    /**
     * 在页面上弹出提示窗口，用户单击确定后，关闭当前页面
     *
     * @param string $msg
     *            提示的信息
     */
    public static function alertAndClose($msg) {
        if (! empty($msg)) {
            $script = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
            $script .= "<script language='javascript' type='text/javascript'>\n";
            $script .= "alert('" . trim($msg) . "');\n";
            $script .= "window.close();";
            $script .= "</script>\n";
            echo $script;
        }
        exit();
    }

    /**
     * 服务器端页面跳转，如果页头已经输出则改为javascript的方式跳转
     *
     * @param <string> $url
     *            要跳转的url
     */
    public static function redirect($url) {
        if (! headers_sent()) {
            header('Location: ' . $url);
            exit();
        }
        // 通过js方式跳转
        self::scriptRedirect($url);
    }

    /**
     *
     * 页面301跳转
     *
     * @param <string> $url
     *            跳转的url路径
     */
    public static function url301Redirect($url) {
        if (empty($url)) {
            return false;
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $url");
            exit();
        }
    }

    /**
     * 字符串加密
     *
     * @param type $encstr,加密的原文            
     * @param type $decstr，当为空时，函数功能为加密，非空时为密文校验            
     * @return string|boolean 当函数为加密供能时返回密文，当为校验功能时返回INT型的bool值
     */
    public static function tokencode($encstr, $decstr = "") {
        $systime = time();
        if (empty($encstr)) {
            return "0";
        }
        if ("" != $decstr) {
            $destrcode = substr($decstr, 0, 32);
            $detimecode = substr($decstr, 32);
            // var_dump(strtotime("Y-m-d H:i:s",$detimecode));
            if (84 == strlen($decstr)) {
                $codetime = Handler_tool::authcode($detimecode);
                if ($systime - $codetime >= 0 && $systime - $codetime <= 3600) {
                    $inttime = $codetime;
                } else {
                    return false;
                }
                return (md5($encstr . $inttime . CRYPT_CODE_KEY) == $destrcode) * 1;
            } else {
                return "0";
            }
        }
        return md5($encstr . $systime . CRYPT_CODE_KEY) . Handler_tool::authcode($systime, "ENCODE");
    }

    /**
     * 字符串加密解密
     *
     * @param str $string
     *            原文或密文
     * @param str $operation
     *            操作(ENCODE | DECODE), 默认为 DECODE
     * @param str $key
     *            密钥
     * @param int $expiry
     *            密文有效期, 加密时候有效， 单位 秒，0 为永久有效
     * @return str 处理后的 原文或者 经过 base64_encode 处理后的密文
     */
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key ? $key : CRYPT_CODE_KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), - $ckey_length)) : '';
        
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        
        $result = '';
        $box = range(0, 255);
        
        $rndkey = array();
        for ($i = 0; $i <= 255; $i ++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        
        for ($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        
        for ($a = $j = $i = 0; $i < $string_length; $i ++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        
        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * 想指定的文件写入内容
     *
     * @param type $fileName
     *            文件名
     * @param type $file_con
     *            文件内容
     * @return string
     */
    public static function write_file($fileName, $file_con) {
        $re_info = "";
        if (is_writable($fileName)) {
            if (! $handle = fopen($fileName, 'w')) {
                $re_info = "不能打开文件 $fileName";
            } else {
                if (fwrite($handle, $file_con) === FALSE) {
                    $re_info = "不能写入到文件 $fileName";
                } else {
                    $re_info = "成功地将 $file_con 写入到文件$fileName";
                    fclose($handle);
                }
            }
        } else {
            $re_info = "文件 $fileName 不可写";
        }
        return $re_info;
    }

    /**
     * 生成指定位数的随机码
     * 如果$en_num,$char_num中某个变量为空，则随机码中不包括该类型字符,当该2个变量均为空时,只取指定位数的数字类型
     *
     * @param int $figure
     *            总位数
     * @param int $en_num
     *            字母位数
     * @param int $char_num
     *            字符位数
     *            return str
     */
    public static function random_code($figure, $en_num = '', $char_num = '') {
        if ((int) $en_num + (int) $char_num > (int) $figure) {
            return false;
        }
        if (empty($figure)) {
            return false;
        }
        $newstr = "";
        $newcharstr = "";
        if (! empty($en_num)) {
            $zmstr = array(
                "c",
                "d",
                "e",
                "f",
                "g",
                "h",
                "i",
                "j",
                "k",
                "m",
                "n",
                "p",
                "q",
                "r",
                "s",
                "t",
                "u",
                "v",
                "w",
                "x",
                "y",
                "z"
            );
            shuffle($zmstr);
            $newstr = substr(implode("", $zmstr), 0, $en_num);
        }
        if (! empty($char_num)) {
            $charstr = array(
                "@",
                "#",
                "-"
            );
            shuffle($charstr);
            $newcharstr = substr(implode("", $charstr), 0, $char_num);
        }
        $digital_num = $figure - $en_num - $char_num;
        $small_str = 2;
        $big_str = 9;
        for ($i = 1; $i < $digital_num; $i ++) {
            $small_str .= 0;
            $big_str .= 9;
        }
        $intnum = mt_rand($small_str, $big_str);
        $l_arr = array(
            $newstr,
            $intnum,
            $newcharstr
        );
        return str_shuffle(implode("", $l_arr));
    }

    /**
     * 获取从当月起12个月的日期
     */
    public static function getMoreMonth() {
        $monthList = array();
        for ($i = 1; $i <= 12; $i ++) {
            $monthList[$i] = date("Y-m", mktime(0, 0, 0, date("m") + $i, 0, date("Y")));
        }
        return $monthList;
    }

    public static function fastcgi_finish_request() {
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    public static function cal_days_in_month_write($month, $year) {
        if (! function_exists('cal_days_in_month')) {
            $lastDay = date('t', mktime(0, 0, 0, $month, 1, $year));
        } else {
            $lastDay = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        return $lastDay;
    }

    public static function utf8_title_substr($str, $width = 0, $end = '...') {
        $length = mb_strlen($str, 'utf8');
        if ($length > $width) {
            return mb_strcut($str, 0, $width, 'utf8') . $end;
        } else {
            return $str;
        }
    }

    public static function filterIdListString($idStr) {
        $idList = explode(",", $idStr);
        $idList = self::filterIdListArray($idList);
        return implode(",", $idList);
    }

    public static function filterIdListArray($idList) {
        $idList = $idList ? $idList : array();
        return array_unique(array_filter($idList, "intval"));
    }
}

?>