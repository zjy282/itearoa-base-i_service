<?php

class ErrorPlugin extends \Yaf_Plugin_Abstract {

    /**
     * 进行路由前
     *
     * @see Yaf_Plugin_Abstract::routerStartup()
     */
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        set_error_handler(array(
            $this,
            'site_error_handler'
        ));
    }

    /**
     * 进行路由后
     * 主要触发拦截器执行before方法
     *
     * @see Yaf_Plugin_Abstract::routerShutdown()
     */
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    /**
     * 主要触发拦截器执行after方法
     *
     * @see Yaf_Plugin_Abstract::dispatchLoopShutdown()
     */
    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    /**
     * 自定义的错误处理函数。
     * 在系统发生严重错误或者trigger_error()被呼叫时执行。
     *
     * @param <int> $errno
     *            错误的级别，整型。为系统预定义错误代码。
     * @param <string> $errstr
     *            错误信息，字符。
     * @param <string> $errfile
     *            产生错误的文件名，可选。
     * @param <int> $errline
     *            产生错误的代码所在的行数，可选。
     * @param <array> $errcontext
     *            错误的上下文变量数组。手机版新架构测试用
     */
    public function site_error_handler($errno, $errstr = "", $errorfile = "", $errline = 0, $errcontext = array()) {
        $sysConfig = Yaf_Registry::get('sysConfig');
        $debug = $sysConfig->application->debug;
        // 根据错误级别记录日志
        $errno = intval($errno);
        $error_log_level = array(
            1,
            2,
            4,
            16,
            32,
            64,
            4096
        );
        if (in_array($errno, $error_log_level)) {
            if ($debug) {
                echo "no:" . $errno . "<br/>";
                echo "error:" . $errstr . "<br/>";
                echo "file:" . $errorfile . "<br/>";
                echo "line:" . $errline . "<br/><br/>";
            }
            // Log_File::writeSysErrorLog($errno, $errstr, $errorfile, $errline, true);
        }
    }
}

?>