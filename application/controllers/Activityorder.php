<?php

/**
 * 活动报名表单控制器类
 *
 */
class ActivityOrderController extends \BaseController {

    /**
     *
     * @var ActivityOrderModel
     */
    private $model;

    /**
     *
     * @var Convertor_ActivityOrder
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new ActivityOrderModel ();
        $this->convertor = new Convertor_ActivityOrder ();
    }

    /**
     * 获取活动报名表单列表
     *
     * @return Json
     */
    public function getActivityOrderListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['name'] = trim($this->getParamList('name'));
        $param ['phone'] = trim($this->getParamList('phone'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['activityid'] = intval($this->getParamList('activityid'));
        $data = $this->model->getActivityOrderList($param);
        $count = $this->model->getActivityOrderCount($param);
        $data = $this->convertor->getActivityOrderListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取活动报名详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getActivityOrderDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getActivityOrderDetail($id);
            $data = $this->convertor->getActivityOrderDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改活动报名信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateActivityOrderByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateActivityOrderById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加活动报名信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addActivityOrderAction() {
        $param = array();
        $param ['name'] = trim($this->getParamList('name'));
        $param ['phone'] = trim($this->getParamList('phone'));
        $param ['remark'] = trim($this->getParamList('remark'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['ordercount'] = intval($this->getParamList('ordercount'));
        $param ['activityid'] = intval($this->getParamList('activityid'));
        if (empty ($param ['name']) || empty ($param ['phone']) || empty ($param ['hotelid']) || empty ($param ['activityid'])) {
            $this->throwException(2, '入参错误');
        }
        $token = trim($this->getParamList('token'));
        $param ['userid'] = Auth_Login::getToken($token);
        if (empty ($param ['userid'])) {
            $this->throwException(5, '登录验证失败');
        }
        $hotelListModel = new HotelListModel ();
        $hotelInfo = $hotelListModel->getHotelListDetail($param ['hotelid']);
        if (empty ($hotelInfo ['id'])) {
            $this->throwException(6, '物业ID错误');
        }
        $param ['groupid'] = $hotelInfo ['groupid'];
        $checkOrder = $this->model->getActivityOrderList(array('name' => $param ['name'], 'phone' => $param ['phone'], 'hotelid' => $param ['hotelid'], 'groupid' => $param ['groupid'], 'activityid' => $param ['activityid']));
        if (count($checkOrder) > 0) {
            $this->throwException(3, '已经存在有效报名，请不要重复提交');
        }
        $data = $this->model->addActivityOrder($param);
        if (!$data) {
            $this->throwException(4, '提交失败');
        }
        $this->echoSuccessData(array('orderId' => $data));
    }
}
