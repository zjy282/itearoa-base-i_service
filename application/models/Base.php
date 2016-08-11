<?php

class BaseModel {

    protected $rpcClient;

    protected $limit;

    protected $partnerId;

    public function __construct() {
        $this->rpcClient = Rpc_HttpDao::getInstance();
        $this->limit = 5;
        $userInfo = Yaf_Registry::get('loginInfo');
        $this->partnerId = $userInfo['partnerId'];
    }

    protected function initParam($paramList) {
        $paramList['package'] = Enum_System::RPC_REQUEST_PACKAGE;
        $paramList['partnerid'] = $this->partnerId;
        $paramList['otaId'] = $this->partnerId;
        return $paramList;
    }

    /**
     * 设置分页
     *
     * @param array $param            
     * @param int $page            
     * @param int $limit            
     * @param number $limitDefault            
     */
    protected function setPageParam(&$params, $page, $limit, $limitDefault = 4) {
        $limit = intval($limit);
        $params['limit'] = $limit ? $limit : $limitDefault;
        $params['page'] = empty($page) ? 1 : intval($page);
    }

    protected function throwException($name, $code) {
        throw new Exception($name, $code);
    }
}

?>