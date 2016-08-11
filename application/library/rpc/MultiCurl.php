<?php
/**
 * 基于 curl_multi 的并行处理
 *
 * 使用示例
 * MultiCurl::add_curl('url1', Helper_Multicurl::mk_curl('get', $url1));
 * MultiCurl::add_curl('url2', Helper_Multicurl::mk_curl('get', $url2));
 * $ret = Helper_Multicurl::multi_exec();
 *
 * @author  肖武 <tsxw24@gmail.com>
 * @version 2012-9-14 15:06 #multicurl.php
 */
class Rpc_MultiCurl {
    private static $mh = null;
    private static $arr_ch = array (); // curl句柄列表
    
    /**
     * 创建curl会话，返回curl句柄
     *
     * @param string $type
     *            请求方式，取值：get，post
     * @param string $url
     *            url地址，可包含问号
     * @param array $data
     *            key-value对，post或get的参数
     * @param array $ex_arg
     *            扩展参数,常用参数如下：
     *            array(
     *            CURLOPT_COOKIE => string 设定HTTP请求中"Cookie:
     *            "部分的内容。多个cookie用分号分隔，分号后带一个空格(例如， "fruit=apple; colour=red")。
     *            CURLOPT_REFERER => string 请求头中"Referer: "的内容
     *            CURLOPT_USERAGENT => string "User-Agent: "头的字符串。如：“Mozilla/4.0
     *            (compatible; MSIE 5.01; Windows NT 5.0)”
     *            CURLOPT_HTTPHEADER => array
     *            header头列表，如：array('host:http://abc.com','Content-type:
     *            text/plain')
     *            CURLOPT_TIMEOUT => int 超时时间，秒
     *            )
     *            
     * @return resource
     */
    static public function mk_curl($type, $url, array $data = array(), array $ex_arg = array()) {
        // 初始化curl会话
        $ch = curl_init ();
        
        // curl参数
        $option = array (
                CURLOPT_RETURNTRANSFER => 1  // 返回请求结果
        );
        
        // get 参数处理(url处理)
        if ($type == 'get' && $data) {
            $url .= (strpos ( $url, '?' ) ? '&' : '?') . http_build_query ( $data );
        }
        $option [CURLOPT_URL] = $url;
        
        // post 参数处理
        if ($type == 'post' && $data) {
            $option [CURLOPT_POSTFIELDS] = $data;
        }
        
        // 其它参数合并
        $option += $ex_arg;
        
        // 批量设置会话参数
        curl_setopt_array ( $ch, $option );
        
        return $ch;
    }
    
    /**
     * 初始化批量curl会话
     */
    static private function _multi_init() {
        if (is_null ( self::$mh )) {
            self::$mh = curl_multi_init ();
        }
    }
    
    /**
     * 清理数据，恢复初始状态
     */
    static private function _clear() {
        self::$mh = null;
        self::$arr_ch = array ();
    }
    
    /**
     * 添加curl句柄到批量处理中
     *
     * @param string $k
     *            用于区分不同请求的key，最终的返回结果会和key对应。若有重复后面的覆盖前面
     * @param resource $ch
     *            curl会话的句柄
     *            
     * @return boolean
     */
    static public function add_curl($k, $ch) {
        self::_multi_init ();
        
        // 添加curl句柄
        $ret = curl_multi_add_handle ( self::$mh, $ch );
        if ($ret != 0) { // 添加失败
            return false;
        }
        
        // 若原来有相同$k,则删除，以便覆盖之
        if (isset ( self::$arr_ch [$k] )) {
            curl_multi_remove_handle ( self::$mh, self::$arr_ch [$k] ); // 移除原curl句柄
            curl_close ( self::$arr_ch [$k] ); // 关闭原curl会话
            unset ( self::$arr_ch [$k] ); // 删除原$k
        }
        self::$arr_ch [$k] = $ch;
        
        return true;
    }
    
    /**
     * 执行批量请求，返回批量数据。原设置的k与其结果一一对应
     *
     * @param array $arr_ch
     *            可选参数。key-curl句柄相对应的列表，用于批量设置curl句柄
     *            
     * @return array
     */
    static public function multi_exec(array $arr_ch = array()) {
        $data = array ();
        
        // 批量添加curl会话句柄
        foreach ( $arr_ch as $k => $ch ) {
            self::add_curl ( $k, $ch );
        }
        
        // 无批量执行句柄，返回空数组
        if (is_null ( self::$mh )) {
            return $data;
        }
        
        // 执行
        do {
            $mrc = curl_multi_exec ( self::$mh, $active );
        } while ( $mrc == CURLM_CALL_MULTI_PERFORM );
        while ( $active && $mrc == CURLM_OK ) {
           // echo 'aaa'; 
            if (curl_multi_select ( self::$mh ) != - 1) {
                do {
                    $mrc = curl_multi_exec ( self::$mh, $active );
                } while ( $mrc == CURLM_CALL_MULTI_PERFORM );
            }
        }
        // 获取返回结果
        foreach ( self::$arr_ch as $k => $ch ) {
            $info = curl_getinfo ( $ch );
            $data ['stat'] [$k] = array (
                    'http_code' => $info ['http_code'],
                    'exec_time' => $info ['total_time'],
                    'size' => $info ['size_download'] 
            );
            if ($info ['http_code'] == 200) {
                $data ['success'] [$k] = 1;
                $data ['data'] [$k] = curl_multi_getcontent ( $ch );
            } else {
                $data ['error'] [$k] = 1;
            }
            
            curl_multi_remove_handle ( self::$mh, $ch ); // 移除句柄
            curl_close ( $ch ); // 关闭会话
        }
        curl_multi_close ( self::$mh ); // 关闭批量会话
                                     
        // 清理数据，恢复初始状态，为下一次使用做好准备
        self::_clear ();
        
        return $data;
    }
}