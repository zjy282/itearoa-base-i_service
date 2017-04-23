<?php

class PushModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Push();
    }

    /**
     * 获取Push列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPushList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['type'] ? $paramList['type'] = $param['type'] : false;
        isset($param['result']) ? $paramList['result'] = intval($param['result']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPushList($paramList);
    }

    /**
     * 获取Push数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPushCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['type'] ? $paramList['type'] = $param['type'] : false;
        isset($param['result']) ? $paramList['result'] = intval($param['result']) : false;
        return $this->dao->getPushCount($paramList);
    }

    /**
     * 根据id查询Push信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPushDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPushDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Push信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePushById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updatePushById($info, $id);
        }
        return $result;
    }

    /**
     * Push新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPush($param) {
        // 判断参数错误
        $info['type'] = intval($param['type']);
        if (empty($info['type'])) {
            $this->throwException('推送类型错误', 3);
        }

        if ($info['type'] == Enum_Push::PUSH_TYPE_ALL) {

        } else if (){ //用户别名
            $dataId = array_unique(array_filter(explode(",", $param['dataid'])));
            if (empty($dataId)) {
                $this->throwException('推送数据ID错误', 2);
            }
            $info['dataid'] = implode(',', $dataId);
        } else if (){ //tag推送
            
        }

        $info['cn_title'] = $param['cn_title'];
        $info['cn_value'] = $param['cn_value'];
        $info['en_title'] = $param['en_title'];
        $info['en_value'] = $param['en_value'];
        if (empty($info['cn_value']) && empty($info['en_value'])) {
            $this->throwException('推送内容错误', 4);
        }

        $info['url'] = $param['url'];
        if (empty($info['url'])) {
            $this->throwException('推送URL错误', 5);
        }

        //@TODO 需要接入推送并保存推送结果状态

        $info['result'] = intval($pushResult);
        $info['createtime'] = time();

        return $this->dao->addPush($info);
    }

    /**
     * 推送消息
     *
     * @param
     *            array param 推送消息信息
     *            $return boolean
     */
    public function pushMsg() {
        $pushResult = Push_Umeng::pushAccountList($type, $msg, $accountList);
    }
}
