<?php

class RecordModel extends BaseModel {

    public function addOperateLog($paramList) {
        $params = $this->initParam(array());
        do {
            $params['operatorId'] = $paramList['adminId'];
            $params['msg'] = $paramList['log'];
            $params['dataid'] = $paramList['dataId'];
            $params['module'] = intval($paramList['module']);
            $params['action'] = intval($paramList['action']);
            $params['ip'] = Util_Http::getIP();
            $params['miscinfo'] = $paramList['otherInfo'];
            $params['code'] = $paramList['code'];
            if (empty($params['operatorId'])) {
                $result = array(
                    'code' => 1,
                    'msg' => 'ID不能为空'
                );
                break;
            }
            $result = $this->rpcClient->getResultRaw('R001', $params, true, 10);
        } while (false);
        return (array) $result;
    }
}