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
     * @param $name string
     * @param $code int
     * @throws Exception
     */
    protected function throwException($name, $code) {
        throw new Exception($name, $code);
    }

    /**
     * Format input params
     *
     * @param array $params
     * @param callable|null $function
     * @return array
     */
    protected function filterParam(array $params, callable $function = null): array
    {
        $result = [];
        foreach ($params as $key => $value) {
            if (is_null($function)) {
                if (!is_null($value)) {
                    $result[$key] = $value;
                    continue;
                }
            }
            if (call_user_func($function, $value)) {
                $result[$key] = $value;
                continue;
            }
        }
        return $result;
    }
}
