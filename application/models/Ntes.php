<?php

/**
 * Class NtesModel
 * 网易云信
 */
class NtesModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    public function userLogin($userId) {
        $result = array("code" => 1);
        do {
            if (empty($userId)) {
                $result["code"] = 1;
                $result["msg"] = "登陆用户ID错误";
                break;
            }

            $userDao = new Dao_User();
            $userInfo = $userDao->getUserDetail($userId);
            $accId = $userInfo["ntes_accid"];
            $userName = $userInfo["room_no"];

            if (!$accId) {
                $registerParams = array(
                    "accId" => Enum_Ntes::makeAccId(Auth_Login::USER_MARK, $userId),
                    "name" => $userName
                );
                $registerRe = Rpc_Ntes::register($registerParams);
                if (empty($registerRe["token"]) || empty($registerRe["accId"])) {
                    $result["code"] = 2;
                    $result["msg"] = "网易云信注册失败";
                    break;
                }
                if (!$userDao->updateUserById(array("ntes_accid" => $registerRe["accId"]), $userId)) {
                    $result["code"] = 3;
                    $result["msg"] = "网易云信保存失败";
                    break;
                }
                $resultData = array(
                    "name" => $registerRe["name"],
                    "token" => $registerRe["token"],
                    "accId" => $registerRe["accId"],
                );
                $result['data'] = $resultData;
            } else {
                $unBlockParams = array(
                    "accId" => Enum_Ntes::makeAccId(Auth_Login::USER_MARK, $userId)
                );
                $unBlockRe = Rpc_Ntes::unBlock($unBlockParams);
                if (!$unBlockRe) {
                    $result["code"] = 4;
                    $result["msg"] = "网易云信解禁失败";
                    break;
                }
                $refreshTokenRe = Rpc_Ntes::refreshToken($unBlockParams);
                if (empty($refreshTokenRe["token"]) || empty($refreshTokenRe["accId"])) {
                    $result["code"] = 2;
                    $result["msg"] = "网易云信Token获取失败";
                    break;
                }
                $resultData = array(
                    "name" => $userName,
                    "token" => $refreshTokenRe["token"],
                    "accId" => $refreshTokenRe["accId"],
                );
                $result['code'] = 0;
                $result['data'] = $resultData;
            }
        } while (false);
        return $result;
    }

    public function refreshUserToken($userId) {
        $result = array("code" => 1);
        do {
            if (empty($userId)) {
                $result["code"] = 1;
                $result["msg"] = "登陆用户ID错误";
                break;
            }
            $userDao = new Dao_User();
            $userInfo = $userDao->getUserDetail($userId);
            $accId = $userInfo["ntes_accid"];
            if (empty($accId)) {
                $result["code"] = 2;
                $result["msg"] = "该用户还未注册网易云信";
                break;
            }
            $refreshTokenParams = array(
                "accId" => $accId
            );
            $refreshTokenRe = Rpc_Ntes::refreshToken($refreshTokenParams);
            if (empty($refreshTokenRe["token"]) || empty($refreshTokenRe["accId"])) {
                $result["code"] = 2;
                $result["msg"] = "网易云信Token获取失败";
                break;
            }
            $resultData = array(
                "name" => $userInfo['room_no'],
                "token" => $refreshTokenRe["token"],
                "accId" => $refreshTokenRe["accId"],
            );
            $result['code'] = 0;
            $result['data'] = $resultData;
        } while (false);
        return $result;
    }

    public function blockUser($userId) {
        $result = array("code" => 1);
        do {
            if (empty($userId)) {
                $result["code"] = 1;
                $result["msg"] = "登陆用户ID错误";
                break;
            }

            $userDao = new Dao_User();
            $userInfo = $userDao->getUserDetail($userId);
            $accId = $userInfo["ntes_accid"];

            if (empty($accId)) {
                $result["code"] = 2;
                $result["msg"] = "坐席未注册";
                break;
            }
            $blockParams = array(
                "accId" => Enum_Ntes::makeAccId(Auth_Login::USER_MARK, $userId)
            );
            $unBlockRe = Rpc_Ntes::block($blockParams);
            if (!$unBlockRe) {
                $result["code"] = 4;
                $result["msg"] = "网易云信封禁失败";
                break;
            }
            $result = array("code" => 0);
        } while (false);
        return $result;
    }
}
