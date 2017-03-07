<?php

/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author ryan
 */
class BasePlugin extends Yaf_Plugin_Abstract {

    private $defaultInterceptor = 'Interceptor_ParamAuth';

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $interceptorConfig = Interceptor_Config::getConfig();
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();
        $interceptorMethodList = isset($interceptorConfig[$controllerName . ',' . $actionName]) ? $interceptorConfig[$controllerName . ',' . $actionName] : $interceptorConfig[$controllerName . ','];
        $interceptorMethodList = is_array($interceptorMethodList) && count($interceptorMethodList) > 0 ? $interceptorMethodList : array(
            $this->defaultInterceptor
        );
        foreach ($interceptorMethodList as $value) {
            $interceptor = new $value();
            $interceptor->before($request, $response);
        }
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $interceptorConfig = Interceptor_Config::getConfig();
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();
        $interceptorMethodList = isset($interceptorConfig[$controllerName . ',' . $actionName]) ? $interceptorConfig[$controllerName . ',' . $actionName] : $interceptorConfig[$controllerName . ','];
        $interceptorMethodList = is_array($interceptorMethodList) && count($interceptorMethodList) > 0 ? $interceptorMethodList : array(
            $this->defaultInterceptor
        );
        if (is_array($interceptorMethodList) && count($interceptorMethodList) > 0) {
            foreach ($interceptorMethodList as $value) {
                $interceptor = new $value();
                $interceptor->after($request, $response);
            }
        }
    }
}
