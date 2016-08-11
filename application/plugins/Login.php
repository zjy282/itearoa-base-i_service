<?php

class LoginPlugin extends \Yaf_Plugin_Abstract {

    /**
     * 进行路由前
     *
     * @see Yaf_Plugin_Abstract::routerStartup()
     */
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    /**
     * 进行路由后
     * 主要触发拦截器执行before方法
     *
     * @see Yaf_Plugin_Abstract::routerShutdown()
     */
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $checkLoginInterceptor = $this->getCheckLoginInterceptor($request->getControllerName(), $request->getActionName());
        if ($checkLoginInterceptor) {
            $checkLoginInterceptor->before($request, $response);
        }
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    /**
     * 主要触发拦截器执行after方法
     *
     * @see Yaf_Plugin_Abstract::dispatchLoopShutdown()
     */
    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $checkLoginInterceptor = $this->getCheckLoginInterceptor($request->getControllerName(), $request->getActionName());
        if ($checkLoginInterceptor) {
            $checkLoginInterceptor->after($request, $response);
        }
    }

    private function getCheckLoginInterceptor($controller, $action) {
        $config = Interceptor_LoginConfig::getAllowConfig();
        if (! in_array($controller . ',' . $action, $config)) {
            $checkLoginInterceptor = Interceptor_LoginConfig::LOGIN_INTERCEPTOR;
            return new $checkLoginInterceptor();
        }
    }
}

?>