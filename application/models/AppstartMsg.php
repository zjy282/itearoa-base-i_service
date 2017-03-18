<?php

class AppstartMsgModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_AppstartMsg();
    }

    /**
     * 获取AppstartMsg列表信息
     * 
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getAppstartMsgList(array $param) {
        isset($param['type']) ? $paramList['type'] = intval($param['type']) : false;
        isset($param['dataid']) ? $paramList['dataid'] = intval($param['dataid']) : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getAppstartMsgList($paramList);
    }

    /**
     * 根据id查询AppstartMsg信息
     * 
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getAppstartMsgDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getAppstartMsgDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新AppstartMsg信息
     * 
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateAppstartMsgById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateAppstartMsgById($info, $id);
        }
        return $result;
    }

    /**
     * AppstartMsg新增信息
     * 
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addAppstartMsg($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addAppstartMsg($info);
    }
}
