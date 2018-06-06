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

        if ($sysConfig->api->checkToke && !$this->isInWhiteList($request) && !$this->_customerCheck($request)) {
            if (empty($timestamp)) {
                throw new Exception("未检测到时间戳", 10001);
            }
            if ($timestamp < time() - $this->_getTimeout($request)) {
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
            if (!$hotelLang) {
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
        $package = $paramList['package'];
        if ($package) {
            Yaf_Registry::set('package', $package);
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

    // 有些外部回调可能未知agent 所以加禁用白名单
    private function isInWhiteList(Yaf_Request_Abstract $request) {
        $controllerName = strtolower($request->getControllerName());
        $actionName = strtolower($request->getActionName());

        // 多了放配置文件
        // 一定要小写
        $whiteList = array( // 方法名都小写
            'system' => array(
                'gettime'
            ),
            'service' => array(
                'orderremind',
            ),
        );

        $flag = false;
        if (isset($whiteList[$controllerName]) && in_array($actionName, $whiteList[$controllerName])) {
            $flag = true;
        }

        return $flag;
    }

    /**
     * Get timeout value for the sign
     *
     * @param Yaf_Request_Abstract $request
     * @param int $default seconds
     * @return int
     */
    private function _getTimeout(Yaf_Request_Abstract $request, $default = 300): int
    {
        $result = $default;
        $controllerName = strtolower($request->getControllerName());
        $actionName = strtolower($request->getActionName());

        if ($controllerName == strtolower("service") && $actionName == strtolower("robotCallback")) {
            $sysConfig = Yaf_Registry::get('sysConfig');
            $result = $sysConfig->robot->callbacktimeout;
        }
        return $result;
    }

    /**
     * Check customer auth
     *
     * @param Yaf_Request_Abstract $request
     * @return bool
     * @throws Exception
     */
    private function _customerCheck(Yaf_Request_Abstract $request)
    {
        $result = false;
        $controllerName = strtolower($request->getControllerName());
        $actionName = strtolower($request->getActionName());
        if ($request->isGet()) {
            $paramList = $request->getQuery();
        } elseif ($request->isPost()) {
            $paramList = $request->getPost();
        } else {
            throw new Exception("未知方法", 10001);
        }

        // For robot
        if ($controllerName == strtolower("service") && $actionName == strtolower("robotCallback")) {
            $timestamp = $paramList["time"];
            $paramSign = $paramList['sign'];

            unset($paramList['sign'], $paramList[trim($request->getRequestUri(), '/')]);
            $sign = Auth_Login::getRobotSign($paramList);
            if (empty($timestamp)) {
                throw new Exception("未检测到时间戳", 10001);
            }
            if ($timestamp < time() - $this->_getTimeout($request)) {
                throw new Exception("时间戳过期", 10002);
            }
            if ($sign !== $paramSign) {
                throw new Exception("验证戳校验错误;{$sign};", 10003);
            } else {
                $result = true;
            }
        }

        return $result;
    }
}
