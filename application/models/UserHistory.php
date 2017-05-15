<?php

/**
 * Class UserHistoryModel
 * 用户入住历史记录Model
 */
class UserHistoryModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_UserHistory();
    }

    /**
     * 获取UserHistory列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getUserHistoryList(array $param) {
        isset($param['userid']) ? $paramList['userid'] = intval($param['userid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getUserHistoryList($paramList);
    }

    /**
     * 根据id查询UserHistory信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getUserHistoryDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getUserHistoryDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新UserHistory信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateUserHistoryById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateUserHistoryById($info, $id);
        }
        return $result;
    }

    /**
     * UserHistory新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addUserHistory($param) {
        $info['userid'] = intval($param['userid']);
        $info['hotelid'] = intval($param['hotelid']);
        $info['groupid'] = intval($param['groupid']);
        $info['checkin'] = time();
        $info['checkout'] = intval($param['checkout']);
        return $this->dao->addUserHistory($info);
    }
}
