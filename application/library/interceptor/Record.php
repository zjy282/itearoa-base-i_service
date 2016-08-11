<?php

class Interceptor_Record extends Interceptor_Base {

    /**
     * (non-PHPdoc) @see Interceptor_Base::before()
     */
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $recordLog = $request->getPost(Enum_Record::RECORD_POST_VAR);
        $recordDataId = $request->getPost(Enum_Record::RECORD_POST_ID);
        if ($recordLog && $recordLog !== 'false') {
            Enum_Record::setRecordData('log', $recordLog);
        }
        Enum_Record::setRecordData('dataId', $recordDataId);
    }

    /**
     * (non-PHPdoc) @see Interceptor_Base::after()
     */
    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $recordData = Yaf_Registry::get(Enum_Record::RECORD_VAR);
        $result = json_decode($response->getBody(), true);
        $module = $request->getControllerName();
        $action = $request->getActionName();
        $recordConfig = Interceptor_RecordConfig::getConfig();
        $recordData['module'] = $recordConfig[$module]['moduleType'];
        $recordData['action'] = $recordConfig[$module]['action'][$action];
        $otherInfo = array();
        if (isset($result)) {
            $otherInfo['result'] = $result['code'] ? '失败' : '成功';
            $otherInfo['msg'] = $result['msg'];
            $recordData['code'] = $result['code'];
            if (empty($recordData['dataId']) && $result['data']['insertId']) {
                $recordData['dataId'] = $result['data']['insertId'];
            }
        }
        $recordData['otherInfo'] = json_encode($otherInfo);
        $recordModel = new RecordModel();
        $recordModel->addOperateLog($recordData);
    }
}

?>