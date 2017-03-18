<?php

class Interceptor_ParamAuth extends \Interceptor_Base {

    /**
     * (non-PHPdoc) @see Interceptor_Base::before()
     */
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $sysConfig = Yaf_Registry::get('sysConfig');
        // 过滤爬虫
        if ($this->isSpider()) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $sysConfig->api->httpUrl);
            exit();
        }
        
        $paramList = array();
        if ($request->isGet()) {
            $paramList = $request->getQuery();
        }
        if ($request->isPost()) {
            $paramList = $request->getPost();
        }
        
        $timestamp = $paramList["time"];
        $paramSign = $paramList['sign'];
        unset($paramList['sign'], $paramList[trim($request->getRequestUri(), '/')]);
        $sign = Auth_Login::genSign($paramList);
        
        if ($sysConfig->api->checkToke) {
            if (empty($timestamp)) {
                throw new Exception("未检测到时间戳", 10001);
            }
            if ($timestamp < time() - 60 * 5) {
                throw new Exception("时间戳过期", 10002);
            }
            if ($sign !== $paramSign) {
                throw new Exception("验证戳校验错误;{$sign};", 10003);
            }
        }
        unset($paramList['timestamp']);
        
        $this->getHotelLangInfo($paramList);
        $request->setParam("paramList", $paramList);
    }

    /**
     * (non-PHPdoc) @see Interceptor_Base::after()
     */
    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    /**
     * 获取酒店当前语言信息
     *
     * @param unknown $paramList            
     */
    private function getHotelLangInfo($paramList) {
        $lang = $paramList['lang'];
        $hotelId = intval($paramList['hotelid']);
        if ($lang && $hotelId) {
            $cache = Cache_Redis::getInstance();
            $cacheKey = Enum_Lang::getHotelLangListCacheKey($hotelId);
            $hotelLang = $cache->get($cacheKey);
            if (! $hotelLang) {
                $hotelListModel = new HotelListModel();
                $hotelLang = $hotelListModel->getHotelListDetail($hotelId)['lang_list'];
                if ($hotelLang) {
                    $cache->set($cacheKey, $hotelLang, 86400);
                }
            }
            $hotelLang = explode(",", $hotelLang);
            Yaf_Registry::set('hotelLangInfo', array(
                'langList' => $hotelLang,
                'lang' => $lang,
                'langIndex' => array_search($lang, $hotelLang) + 1
            ));
        }
    }

    private function getUserAgent() {
        return isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "";
    }

    private function isSpider() {
        $userAgent = $this->getUserAgent();
        if (empty($userAgent)) {
            return false;
        }
        
        $spiderAgents = array(
            "QunarBot",
            "Mediapartners",
            "Yahoo",
            "AdsBot",
            "LWP",
            "Sogou",
            "curl",
            "bingbot",
            "lwp-trivial",
            "HuaweiSymantecSpider",
            "msnbot",
            "ezooms",
            'Sosospider',
            'Googlebot',
            'Mediapartners-Google',
            'YodaoBot',
            'Baiduspider'
        );
        
        foreach ($spiderAgents as $spiderAgent) {
            if (stripos($userAgent, $spiderAgent) !== false)
                return true;
        }
        
        return false;
    }
}

?>
