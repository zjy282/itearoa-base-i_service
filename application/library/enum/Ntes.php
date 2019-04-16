<?php

/**
 * 网易云信枚举
 * @author ZXM
 */
class Enum_Ntes {

    const APP_KEY = '1de3fb2830f92f71d69bf749f9dcb3cd';
    const APP_SECRET = '6f24663b70bd';

    const REGISTER_RPC = "https://api.netease.im/nimserver/user/create.action";
    const REFRESH_TOKEN_RPC = "https://api.netease.im/nimserver/user/refreshToken.action";
    const BLOCK_RPC = "https://api.netease.im/nimserver/user/block.action";
    const UNBLOCK_RPC = "https://api.netease.im/nimserver/user/unblock.action";

    public static function makeAccId($type, $userId) {
        return md5($type . "_" . $userId);
    }

}