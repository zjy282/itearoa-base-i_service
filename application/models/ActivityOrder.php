<?php

class ActivityOrderModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ActivityOrder();
    }

    /**
     * 获取ActivityOrder列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getActivityOrderList(array $param) {
        isset($param['name']) ? $paramList['name'] = strval($param['name']) : false;
        isset($param['phone']) ? $paramList['phone'] = strval($param['phone']) : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['activityid']) ? $paramList['activityid'] = intval($param['activityid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getActivityOrderList($paramList);
    }

    /**
     * 根据id查询ActivityOrder信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getActivityOrderDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getActivityOrderDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ActivityOrder信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateActivityOrderById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateActivityOrderById($info, $id);
        }
        return $result;
    }

    /**
     * ActivityOrder新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addActivityOrder($param) {
        $info['name'] = $param['name'];
        $info['phone'] = $param['phone'];
        $info['hotelid'] = intval($param['hotelid']);
        $info['activityid'] = intval($param['activityid']);
        $info['userid'] = intval($param['userid']);
        $info['creattime'] = time();
        return $this->dao->addActivityOrder($info);
    }
}
