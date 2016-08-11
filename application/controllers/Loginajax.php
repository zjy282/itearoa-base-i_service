<?php

class LoginajaxController extends \BaseController {

    /**
     * 登陆请求
     */
    public function doLoginAction() {
        $request = $this->getRequest();
        $paramList['username'] = $request->getPost('username');
        $paramList['password'] = $request->getPost('password');
        
        $model = new LoginModel();
        $result = $model->doLogin($paramList);
        
        $this->echoJson($result);
    }
}
