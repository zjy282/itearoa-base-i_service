<?php

/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author ryan
 */
class ErrorController extends BaseController {

    // 从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception) {
        if ($exception->getCode() == YAF_ERR_NOTFOUND_CONTROLLER) {
            $errorCode = 0;
            $errorMsg = "success";
            $debugInfo = array(
                "message" => $exception->getMessage(),
                "code" => $exception->getCode()
            );
        } elseif ($exception->getCode() > 1000 || !is_numeric($exception->getCode())) {
            // 错误code大于1000时统一抛出给前段错误为系统错误，debug信息可看到具体错误消息
            $errorCode = 1;
            $errorMsg = "系统错误";
            $debugInfo = array(
                "message" => $exception->getMessage(),
                "code" => $exception->getCode()
            );

            $logMsg = json_encode($echoList = array(
                    'code' => $errorCode,
                    'msg' => $debugInfo
                )) . "\r\n";
            $logMsg .= "params :" . json_encode($this->getParamList());
            Log_File::writeLog('error', $logMsg);
        } else {
            $errorCode = $exception->getCode();
            $errorCode = empty($errorCode) ? 1 : $errorCode;
            $errorMsg = $exception->getMessage();
        }
        $result = $this->echoAndExit($errorCode, $errorMsg, array(), $debugInfo);
        $this->getResponse()->setBody($result);
    }
}
