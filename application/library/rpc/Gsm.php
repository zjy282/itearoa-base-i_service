<?php

class Rpc_Gsm {

    private function __construct() {
    }

    public static function send($interface, $params, $timeOut = 10) {
        $url = $interface . '?' . http_build_query($params);
        $respone = Util_Http::fileGetContentsWithTimeOut($url, $timeOut);
        $result = json_decode($respone, true);
        return $result;
    }
}