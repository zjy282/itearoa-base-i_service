<?php

class BaseController extends \Yaf_Controller_Abstract {

    protected $userInfo;

    public function init() {
        $this->setPageWebConfig();
        $this->userInfo = Yaf_Registry::get('loginInfo');
        $this->setPageHeaderInfo($this->userInfo);
        $this->setPageMenuList($this->userInfo);
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

    private function setPageHeaderInfo($loginInfo) {
        $headerInfo['userName'] = $loginInfo['realName'] ? $loginInfo['realName'] : $loginInfo['userName'];
        $headerInfo['partnerName'] = $loginInfo['partnerName'];
        $this->getView()->assign('headerInfo', $headerInfo);
    }

    private function setPageMenuList($loginInfo) {
        $loginModel = new LoginModel();
        $paramList['id'] = $loginInfo['id'];
        $menuList = $loginModel->getRuleList($paramList);
        $this->_view->assign('menuList', $menuList['data']);
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
     * 获取分页参数
     *
     * @param array $paramList
     *            传入引用
     */
    public function getPageParam(&$paramList) {
        $page = $this->_request->getPost('page');
        $limit = $this->_request->getPost('limit');
        $paramList['page'] = empty($page) ? 1 : $page;
        $paramList['limit'] = empty($limit) ? 5 : $limit;
    }

    protected function jump404() {
        header('Location:/error/notfound');
        exit();
    }
}
