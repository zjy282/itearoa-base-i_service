<?php

class Interceptor_LoginAuth extends Interceptor_Base {

    /**
     * (non-PHPdoc) @see Interceptor_Base::before()
     */
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        if (! ($loginInfo = Auth_Login::checkLogin())) {
            if ($this->requestedWithXhr()) {
                $this->returnJson403();
            } else {
                Util_Tools::redirect('/login/');
            }
        }
        $loginModel = new LoginModel();
        $menuList = $loginModel->getRuleList($loginInfo)['data'];
        $url = '/' . $request->getControllerName() . '/' . $request->getActionName();
        $flag = strtolower($url) == '/index/index' ? true : false;
        foreach ($menuList as $v1) {
            foreach ($v1['list'] as $v2) {
                if (strtolower($url) == strtolower($v2['url']) && $v2['checked']) {
                    $flag = true;
                    break 2;
                }
                if ($v2['list']) {
                    foreach ($v2['list'] as $v3) {
                        if (strtolower($url) == strtolower($v3['url']) && $v3['checked']) {
                            $flag = true;
                            break 3;
                        }
                    }
                }
            }
        }
        if (! $flag) {
            $this->denyAccess();
        }
    }

    /**
     * (non-PHPdoc) @see Interceptor_Base::after()
     */
    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    protected function denyAccess() {
        if ($this->requestedWithXhr()) {
            $this->returnJson403();
        } else {
            $this->returnHtml403();
        }
    }

    protected function requestedWithXhr() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    protected function returnJson403() {
        header('Content-Type:application/json;charset=utf-8');
        echo json_encode(array(
            'code' => '403',
            'msg' => '禁止访问'
        ));
        exit();
    }

    protected function returnHtml403() {
        Util_Tools::redirect('/error/denyaccess');
    }
}

?>
