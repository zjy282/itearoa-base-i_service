<?php

class Rpc_Curl
{
    /**
     *
     * @param string $url
     * @param string $method get post
     * @param mixed $postData
     * @param int $timeOut
     * @return mixed
     */
    public static function request($url, $method = 'GET', $postData = '', $isJsonDecode = false, $timeOut = 10)
    {
        $handle = curl_init();
        //https request
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($method == 'GET') {
            $url = $url . '?' . http_build_query($postData);
        }
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_USERAGENT, Enum_System::RPC_REQUEST_UA);
        curl_setopt($handle, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, 1);
        if (!empty ($postData)) {
            curl_setopt($handle, CURLOPT_POSTFIELDS, $postData);
        }
        $result['response'] = curl_exec($handle);
        $result['httpStatus'] = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $result['fullInfo'] = curl_getinfo($handle);
        curl_close($handle);
        if ($isJsonDecode) {
            $result = self::stripResult($result, true);
        }
        return $result;
    }

    /**
     * @param $httpRet
     * @param bool $isJsonDecode
     * @return bool|mixed
     */
    public static function stripResult($httpRet, $isJsonDecode = false)
    {
        $responseResult = false;
        if ($httpRet['httpStatus']) {
            $responseRaw = $httpRet['response'];
        }
        if (!empty($responseRaw)) {
            if ($isJsonDecode) {
                if (substr($responseRaw, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
                    $responseRaw = substr($responseRaw, 3);
                }
                $responseResult = json_decode($responseRaw, true);
            } else {
                $responseResult = $responseRaw;
            }
        }
        return $responseResult;
    }
}
