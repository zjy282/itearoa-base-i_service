<?php
class Rpc_Curl {
    /**
     * 
     * @param string $url
     * @param string $method get post
     * @param unknown_type $postData
     * @param unknown_type $timeOut
     * @return mixed
     */
    public static function _request($url, $method = 'GET', $postData = '', $timeOut = 2) {
        $handle = curl_init ();
        //https 请求
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
        	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        	curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt ( $handle, CURLOPT_URL, $url );
        curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $handle, CURLOPT_USERAGENT, Enum_System::RPC_REQUEST_UA );
        curl_setopt ( $handle, CURLOPT_TIMEOUT, $timeOut );
        curl_setopt ( $handle, CURLOPT_CUSTOMREQUEST, $method );
        curl_setopt ( $handle, CURLOPT_FOLLOWLOCATION, 1 );
        if (! empty ( $postData )){
            curl_setopt ( $handle, CURLOPT_POSTFIELDS, $postData );
        }
        $result['response'] = curl_exec ( $handle );
        $result['httpStatus'] = curl_getinfo ( $handle, CURLINFO_HTTP_CODE );
        $result['fullInfo'] = curl_getinfo ( $handle );
        curl_close ( $handle );
        
        return $result;
    }
}
