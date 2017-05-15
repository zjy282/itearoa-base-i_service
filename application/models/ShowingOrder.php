<?php

/**
 * Class ShowingOrderModel
 * 预约看房订单管理
 */
class ShowingOrderModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShowingOrder();
    }

    /**
     * 获取ShowingOrder列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShowingOrderList(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = strval($param['id']) : false;
        $param['contact_name'] ? $paramList['contact_name'] = strval($param['contact_name']) : false;
        $param['contact_mobile'] ? $paramList['contact_mobile'] = strval($param['contact_mobile']) : false;
        $param['userid'] ? $paramList['userid'] = intval($param['userid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['status'] ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShowingOrderList($paramList);
    }

    /**
     * 获取ShowingOrder数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShowingOrderCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = strval($param['id']) : false;
        $param['contact_name'] ? $paramList['contact_name'] = strval($param['contact_name']) : false;
        $param['contact_mobile'] ? $paramList['contact_mobile'] = strval($param['contact_mobile']) : false;
        $param['userid'] ? $paramList['userid'] = intval($param['userid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['status'] ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getShowingOrderCount($paramList);
    }

    /**
     * 根据id查询ShowingOrder信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShowingOrderDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShowingOrderDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ShowingOrder信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShowingOrderById($param, $id) {
        $result = false;
        if ($id) {
            $info['status'] = intval($param['status']);
            $info['adminid'] = intval($param['adminid']);
            $result = $this->dao->updateShowingOrderById($info, $id);
        }
        return $result;
    }

    /**
     * ShowingOrder新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addShowingOrder($param) {
        $info['contact_name'] = $param['contact_name'];
        $info['contact_mobile'] = $param['contact_mobile'];
        $info['hotelid'] = intval($param['hotelid']);
        $info['userid'] = intval($param['userid']);
        $info['createtime'] = time();
        $info['status'] = Enum_ShowingOrder::ORDER_STATUS_WAIT;
        return $this->dao->addShowingOrder($info);
    }
}
