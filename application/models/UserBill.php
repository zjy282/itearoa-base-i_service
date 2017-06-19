<?php

/**
 * Class UserModel
 * APP用户账单管理
 */
class UserBillModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_UserBill();
    }

    /**
     * 获取用户账单列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getUserBillList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['room_no'] ? $paramList['room_no'] = $param['room_no'] : false;
        $param['name'] ? $paramList['name'] = $param['name'] : false;
        $param['userid'] ? $paramList['userid'] = $param['userid'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = $param['hotelid'] : false;
        $param['date'] ? $paramList['date'] = $param['date'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getUserBillList($paramList);
    }

    /**
     * 获取用户账单数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getUserBillCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['room_no'] ? $paramList['room_no'] = $param['room_no'] : false;
        $param['name'] ? $paramList['name'] = $param['name'] : false;
        $param['userid'] ? $paramList['userid'] = $param['userid'] : false;
        $param['hotelid'] ? $paramList['hotelid'] = $param['hotelid'] : false;
        $param['date'] ? $paramList['date'] = $param['date'] : false;
        isset($param['status']) ? $paramList['status'] = intval($param['status']) : false;
        return $this->dao->getUserBillCount($paramList);
    }

    /**
     * 根据id查询用户账单信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getUserBillDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getUserBillDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新用户账单信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateUserBillById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
            isset($param['room_no']) ? $info['room_no'] = $param['room_no'] : false;
            isset($param['name']) ? $info['name'] = $param['name'] : false;
            isset($param['userid']) ? $info['userid'] = $param['userid'] : false;
            isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
            isset($param['date']) ? $info['date'] = $param['date'] : false;
            isset($param['status']) ? $info['status'] = $param['status'] : false;
            $info['updatetime'] = time();
            $result = $this->dao->updateUserBillById($info, $id);
        }
        return $result;
    }

    /**
     * 用户账单新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addUserBill($param) {
        isset($param['hotelid']) ? $info['hotelid'] = $param['hotelid'] : false;
        isset($param['room_no']) ? $info['room_no'] = $param['room_no'] : false;
        isset($param['name']) ? $info['name'] = $param['name'] : false;
        isset($param['userid']) ? $info['userid'] = $param['userid'] : false;
        isset($param['pdf']) ? $info['pdf'] = $param['pdf'] : false;
        isset($param['date']) ? $info['date'] = $param['date'] : false;
        isset($param['status']) ? $info['status'] = $param['status'] : false;
        $info['createtime'] = $info['updatetime'] = time();
        return $this->dao->addUserBill($info);
    }

}
