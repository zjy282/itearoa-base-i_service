<?php

/**
 * 获取/设置 http 传来的各种参数
 * 
 * @author rico 
 */
class Util_Http {

    /**
     * 获取cookie值
     *
     * @param string $key            
     * @return string /array
     */
    public static function getCookie($key) {
        if (empty($key)) {
            return $_COOKIE;
        } else {
            return isset($_COOKIE[$key]) ? trim($_COOKIE[$key]) : false;
        }
    }

    /**
     * 设置cookie
     *
     * @param <string> $name
     *            cookie名
     * @param <string> $value
     *            cookie值
     * @param <int> $expire
     *            过期时效，以秒为单位
     * @param <string> $path
     *            路径，默认根目录
     * @param <string> $domain
     *            域名，默认根域名
     * @param <bool> $secure
     *            是否只在https协议下有效
     * @param <bool> $httponly
     *            是否只在http协议下有效，js将无法访问
     * @return <bool> 设置成功返回true，否则返回false
     */
    public static function setCookie($name, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false) {
        if (empty($name)) {
            return false;
        }
        $path = empty($path) ? '/' : $path;
        // $domain = empty($domain) ? COOKIE_DOMAIN : $domain;
        $domain = empty($domain) ? $_SERVER['HTTP_HOST'] : $domain;
        header('P3P: CP=CAO PSA OUR');
        $_COOKIE[$name] = $value;
        return setcookie($name, $value, (int) $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * 设置只有php可以读取的cookie
     *
     * @param str $name            
     * @param str $value            
     * @param int $expire            
     * @return bool
     */
    public static function setPhpCookie($name, $value, $expire = 0) {
        return self::setCookie($name, $value, $expire, '/', '', FALSE, TRUE);
    }

    /**
     * 删除cookie
     *
     * @param <string> $name
     *            要删除的cookie的名字
     */
    public static function delCookie($name) {
        return self::setCookie($name, "", time() - 3600);
    }

    /**
     * 获取session值
     *
     * @param string $key            
     * @return string /array
     */
    public static function getSession($key) {
        if (empty($key)) {
            return $_SESSION;
        } else {
            return isset($_SESSION[$key]) ? trim($_SESSION[$key]) : false;
        }
    }

    /**
     * 设置session值
     *
     * @param string $key            
     * @param string $value            
     * @return boolean
     */
    public static function setSession($key, $value) {
        if (empty($key)) {
            return false;
        } else {
            $_SESSION[$key] = $value;
        }
        return true;
    }

    /**
     * 删除session
     *
     * @param <string> $key
     *            要删除的session的key
     * @return boolean 删除成功返回true，否则返回false
     */
    public static function delSession($key) {
        return self::setSession($key, null);
    }

    /**
     * 获取当前请求的method，如POST，GET
     *
     * @return <string> 所有值均大写，有GET, HEAD, POST, PUT
     */
    public static function getMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /*
     * 设置页面无缓存
     */
    public static function setNoCache() {
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header("Pragma: no-cache");
        header("Referer: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    /**
     * 过滤sql关键字，转义敏感字符
     *
     * @param mixed $sql_str            
     * @return mixed
     */
    public static function injectCheck($sql_str) {
        if (is_array($sql_str)) {
            foreach ($sql_str as $key => $value) {
                if ($key != 'backurl')
                    $sql_str[$key] = self::injectCheck($value);
            }
        } else 
            if (is_string($sql_str)) {
                // 过滤sql关键字
                $sql_str = preg_replace("/select|insert|update|delete|union|into|load_file|outfile|\*| and | or /i", " ", $sql_str);
                // 过滤html标签
                // $new_sql_str = filter_var($sql_str, FILTER_SANITIZE_STRING);
                // if (false !== $new_sql_str) {
                // $sql_str = $new_sql_str;
                // }
                // 转义单引号和双引号
                if (get_magic_quotes_gpc() == 0) {
                    $sql_str = addslashes($sql_str);
                }
            }
        return $sql_str;
    }

    /**
     * 获取客户端IP地址
     * 在CDN下，$_SERVER ["REMOTE_ADDR"]所取的数据会有误
     *
     * @return string 客户端的IP地址
     */
    public static function getIP() {
        // 测试外地IP START
        if (! empty($_COOKIE['test_ip'])) {
            return $_COOKIE['test_ip'];
        }
        // 测试外地IP END
        if (isset($_SERVER["HTTP_CDN_SRC_IP"])) {
            return $_SERVER["HTTP_CDN_SRC_IP"];
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match('/^[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER["REMOTE_ADDR"];
    }

    /**
     * 获取指定的GET参数，已进行SQL Injection处理
     *
     * @param <string> $key
     *            GET参数的key
     * @return <string> GET参数的值
     */
    public static function getGet($key) {
        return self::injectCheck($_GET[$key]);
    }

    /**
     * 获取指定的POST参数，已进行SQL Injection处理
     *
     * @param <string> $key
     *            POST参数的key
     * @return <string> POST参数的值
     */
    public static function getPOST($key) {
        return self::injectCheck($_POST[$key]);
    }

    /**
     * 处理file_get_contents并包含超时
     *
     * @param string $url
     *            需要访问的url
     * @param number $timeout
     *            超市事件
     * @return boolean|string
     */
    public static function fileGetContentsWithTimeOut($url = "", $timeout = 5) {
        if (empty($url)) {
            return false;
        }
        $opts = array(
            'http' => array(
                'method' => "GET",
                'timeout' => $timeout
            )
        );
        $context = stream_context_create($opts);
        return file_get_contents($url, null, $context);
    }
}
?>
