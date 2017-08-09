<?php

/**
 * Class IserviceFeedbackModel
 * 系统反馈Model
 */
class IserviceFeedbackModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_IserviceFeedback();
    }

    /**
     * 获取IserviceFeedback列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getIserviceFeedbackList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['email'] ? $paramList['email'] = $param['email'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getIserviceFeedbackList($paramList);
    }

    /**
     * 获取IserviceFeedback数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getIserviceFeedbackCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['email'] ? $paramList['email'] = $param['email'] : false;
        $param['groupid'] ? $paramList['groupid'] = $param['groupid'] : false;
        return $this->dao->getIserviceFeedbackCount($paramList);
    }

    /**
     * 根据id查询IserviceFeedback信息
     * @param int id 查询的主键
     * @return array
     */
    public function getIserviceFeedbackDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getIserviceFeedbackDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新IserviceFeedback信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateIserviceFeedbackById($param, $id) {
        $result = false;
        if ($id) {
            isset($param['email']) ? $info['email'] = $param['email'] : false;
            isset($param['content']) ? $info['content'] = $param['content'] : false;
            $result = $this->dao->updateIserviceFeedbackById($info, $id);
        }
        return $result;
    }

    /**
     * IserviceFeedback新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addIserviceFeedback($param) {
        isset($param['email']) ? $info['email'] = $param['email'] : false;
        isset($param['content']) ? $info['content'] = $param['content'] : false;
        isset($param['createtime']) ? $info['createtime'] = $param['createtime'] : false;
        isset($param['groupid']) ? $info['groupid'] = $param['groupid'] : false;
        return $this->dao->addIserviceFeedback($info);
    }
}
