<?php

class UserHistoryController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new UserHistoryModel();
        $this->convertor = new Convertor_UserHistory();
    }

    public function getUserHistoryAction() {
        $token = trim($this->getParamList('token'));
        $param = array();
        $param['userid'] = Auth_Login::getToken($token);
        if (empty($param['userid'])) {
            $this->throwException(2, 'token验证失败');
        }
        
        $historyList = $this->model->getUserHistoryList($param);
        $historyList = $this->convertor->userHistoryListConvertor($historyList);
        $this->echoSuccessData($historyList);
    }
}
