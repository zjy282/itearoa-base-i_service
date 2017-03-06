<?php

abstract class BaseController extends \Yaf_Controller_Abstract {

    public function init() {
        $this->setPageWebConfig();
    }

    private function setPageWebConfig() {
        $sysConfig = Yaf_Registry::get('sysConfig');
        $webConfig['layoutPath'] = $sysConfig->application->layout_path;
        $webConfig['domain'] = $sysConfig->web->domain;
        $webConfig['imgDomain'] = $sysConfig->web->img_domain;
        $webConfig['assertPath'] = $sysConfig->web->assert_path;
        $webConfig['defaultIcon'] = $sysConfig->web->img_domain . 'img/temp/noImageIcon.jpg';
        $this->getView()->assign('webConfig', $webConfig);
    }

    /**
     * 输出json
     *
     * @param array $data            
     */
    public function echoJson($data) {
        $response = $this->getResponse();
        $response->setHeader('Content-type', 'application/json');
        $response->setBody(json_encode($data));
    }

    /**
     * 接口访问成功
     *
     * @param array $data
     *            成功返回的数据
     * @return string
     */
    public function echoSuccessData($data = array()) {
        if (! is_array($data) && ! is_object($data)) {
            $data = array(
                    $data
                    );
        }
        $this->echoAndExit(0, "success", $data);
    }

    public function echoAndExit($code, $msg, $data, $debugInfo = null) {
        @header("Content-type:application/json");

        $data = $this->clearNullNew($data);
        if (is_null($data) && ! is_numeric($data)) {
            $data = array();
        }

        $echoList = array(
                'code' => $code,
                'msg' => $msg,
                'data' => $data
                );
        $sysConfig = Yaf_Registry::get('sysConfig');
        if ($sysConfig->api->debug) {
            $echoList['debugInfo'] = is_null($debugInfo) ? (object) array() : $debugInfo;
        }
        $this->getResponse()->setBody(json_encode($echoList));
    }

    public function clearNullNew($data) {
        foreach ($data as $key => $value) {
            $keyTemp = lcfirst($key);
            if ($keyTemp != $key) {
                unset($data[$key]);
                $data[$keyTemp] = $value;
                $key = $keyTemp;
            }

            if (is_array($value) || is_object($value)) {
                if (is_object($data)) {
                    $data->$key = $this->clearNullNew($value);
                } else {
                    $data[$key] = $this->clearNullNew($value);
                }
            } else {
                if (is_null($value) && ! is_numeric($value)) {
                    $value = "";
                }
                if (is_numeric($value)) {
                    $value = strval($value);
                }
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * 抛出异常
     *
     * @param string $code
     * @param string $msg
     * @throws Exception
     */
    protected function throwException($code, $msg) {
        throw new Exception($msg, $code);
    }

    /**
     * 获取分页参数
     *
     * @param array $paramList
     *            传入引用
     */
    public function getPageParam(&$paramList) {
        $page = $this->getRequest()->getParam->getPost('page');
        $limit = $this->getRequest()->getParam->getPost('limit');
        $paramList['page'] = empty($page) ? 1 : $page;
        $paramList['limit'] = empty($limit) ? 5 : $limit;
    }

    protected function jump404() {
        header('Location:/error/notfound');
        exit();
    }
}
