<?php

class ShowingOrderController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new ShowingOrderModel();
        $this->convertor = new Convertor_ShowingOrder();
    }

    /**
     * 获取ShowingOrder列表
     *
     * @return Json
     */
    public function getShowingOrderListAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getShowingOrderList($param);
        $data = $this->convertor->getShowingOrderListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取ShowingOrder详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getShowingOrderDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getShowingOrderDetail($id);
            $data = $this->convertor->getShowingOrderDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改ShowingOrder信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateShowingOrderByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateShowingOrderById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加ShowingOrder信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addShowingOrderAction() {
        $param = array();
        $param['contact_name'] = trim($this->getParamList('contact_name'));
        $param['contact_mobile'] = trim($this->getParamList('contact_mobile'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        
        if (empty($param['contact_name']) || empty($param['contact_mobile']) || empty($param['hotelid'])) {
            $this->throwException(2, '入参错误');
        }
        
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token);
        $userId ? $param['userid'] = $userId : false;
        
        $checkOrder = $this->model->getShowingOrderList(array(
            'contact_name' => $param['contact_name'],
            'contact_mobile' => $param['contact_mobile'],
            'hotelid' => $param['hotelid'],
            'status' => array(
                Enum_ShowingOrder::ORDER_STATUS_WAIT,
                Enum_ShowingOrder::ORDER_STATUS_SERVICE
            )
        ));
        if (count($checkOrder) > 0) {
            $this->throwException(3, '已经存在有效订单，请不要重复提交');
        }
        $data = $this->model->addShowingOrder($param);
        if (! $data) {
            $this->throwException(4, '提交失败');
        }
        $this->echoSuccessData(array(
            'orderId' => $data
        ));
    }
}
