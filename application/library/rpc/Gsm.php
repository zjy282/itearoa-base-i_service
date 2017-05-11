<?php

class Rpc_Gsm {

    private function __construct() {
    }

    public static function makeGsmUrl($interface, $params) {
        $url = $interface . '?' . http_build_query($params);
        return $url;
    }

    public static function send($interface, $params, $timeOut = 10) {
        $url = self::makeGsmUrl($interface, $params);
        $respone = Util_Http::fileGetContentsWithTimeOut($url, $timeOut);
        $result = json_decode($respone, true);
        return $result;
    }
}