<?php

/**
 * Class BaseModel
 * 基础Model
 */
class BaseModel {

    /**
     * @var Rpc_HttpDao 接口控制器
     */
    protected $rpcClient;

    /**
     * @var int 分页limit
     */
    protected $limit;

    public function __construct() {
        $this->rpcClient = Rpc_HttpDao::getInstance();
        $this->limit = 5;
    }

    /**
     * 初始化接口入参
     * @param $paramList
     * @return array
     */
    protected function initParam($paramList) {
        $paramList['package'] = Enum_System::RPC_REQUEST_PACKAGE;
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

    /**
     * 抛出异常
     * @param $name 异常消息
     * @param $code 异常code
     * @throws Exception
     */
    protected function throwException($name, $code) {
        throw new Exception($name, $code);
    }
}

?>