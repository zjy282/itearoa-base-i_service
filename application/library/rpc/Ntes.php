<?php

class Rpc_Ntes {

    private function __construct() {
    }

    private static function makePublicHeader() {
        $publicHeader = array();
        $publicHeader["AppKey"] = Enum_Ntes::APP_KEY;
        $publicHeader["Nonce"] = Util_Tools::random_code(128, 64);
        $publicHeader["CurTime"] = time();
        $publicHeader["CheckSum"] = sha1(Enum_Ntes::APP_SECRET . $publicHeader["Nonce"] . $publicHeader["CurTime"]);

        $publicHeaderRe = array();
        foreach ($publicHeader as $key => $value) {
            $publicHeaderRe[] = $key . ":" . $value;
        }
        return $publicHeaderRe;
    }

    public static function register($params, $timeOut = 10) {
        $accId = $params["accId"];
        if (empty($accId)) {
            return false;
        }
        $postData = array();
        $postData["accid"] = $accId;
        if ($params["name"]) {
            $postData["name"] = $params["name"];
        }
        $response = Rpc_Curl::request(Enum_Ntes::REGISTER_RPC, 'POST', $postData, true, $timeOut, self::makePublicHeader());
        $result = $response["info"];
        if ($response["code"] != 200 || empty($result["token"])) {
            return false;
        }
        return array(
            "name" => $result["name"],
            "accId" => $result["accid"],
            "token" => $result["token"]
        );
    }

    public static function refreshToken($params, $timeOut = 10) {
        if (empty($params["accId"])) {
            return false;
        }
        $postData = array("accid" => $params["accId"]);
        $response = Rpc_Curl::request(Enum_Ntes::REFRESH_TOKEN_RPC, 'POST', $postData, true, $timeOut, self::makePublicHeader());
        $result = $response["info"];
        if ($response["code"] != 200 || empty($result["token"])) {
            return false;
        }
        return array(
            "accId" => $result["accid"],
            "token" => $result["token"]
        );
    }

    public static function block($params, $timeOut = 10) {
        if (empty($params["accId"])) {
            return false;
        }
        $postData = array("accid" => $params["accId"], "needkick" => true);
        $response = Rpc_Curl::request(Enum_Ntes::BLOCK_RPC, 'POST', $postData, true, $timeOut, self::makePublicHeader());
        if ($response["code"] != 200) {
            return false;
        }
        return true;
    }

    public static function unBlock($params, $timeOut = 10) {
        if (empty($params["accId"])) {
            return false;
        }
        $postData = array("accid" => $params["accId"]);
        $response = Rpc_Curl::request(Enum_Ntes::UNBLOCK_RPC, 'POST', $postData, true, $timeOut, self::makePublicHeader());
        if ($response["code"] != 200) {
            return false;
        }
        return true;
    }
}