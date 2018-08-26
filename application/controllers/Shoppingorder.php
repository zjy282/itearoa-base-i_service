<?php

use Frankli\Itearoa\Models\ShoppingOrder;

/**
 * 体验购物订单控制器类
 *
 */
class ShoppingOrderController extends \BaseController
{

    /**
     *
     * @var ShoppingOrderModel
     */
    private $model;

    /**
     *
     * @var Convertor_ShoppingOrder
     */
    private $convertor;

    public function init()
    {
        parent::init();
        $this->model = new ShoppingOrderModel ();
        $this->convertor = new Convertor_ShoppingOrder ();
    }

    /**
     * 获取体验购物订单列表
     *
     * @return Json
     */
    public function getShoppingOrderListAction()
    {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $adminId = Auth_Login::getToken($this->getParamList('token'), 2);
        if (empty ($adminId)) {
            $this->throwException(3, 'token验证失败');
        }
        if (empty ($param ['hotelid'])) {
            $this->throwException(2, '物业Id错误');
        } else {
            $staffModel = new StaffModel();
            $staffInfo = $staffModel->getStaffDetail($adminId);
            if ($staffInfo['hotelid'] != $param ['hotelid']) {
                $this->throwException(2, 'hotel and staff info not match');
            }
        }
        $param['status'] = [Enum_ShoppingOrder::ORDER_STATUS_WAIT, Enum_ShoppingOrder::ORDER_STATUS_SERVICE];

        $this->getPageParam($param);
        $list = $this->model->getShoppingOrderList($param);
        $count = $this->model->getShoppingOrderCount($param);
        $data = $this->convertor->getShoppingOrderListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 后台体验购物订单列表查询
     *
     * @return json
     */
    public function getOrderListAction()
    {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['shoppingid'] = intval($this->getParamList('shoppingid'));
        $param ['userid'] = intval($this->getParamList('userid'));
        $param['status'] = $this->getParamList('status');
        $data = $this->model->getShoppingOrderList($param);
        $count = $this->model->getShoppingOrderCount($param);
        $data = $this->convertor->getOrderListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * Output json for filter of the order list
     */
    public function getOrderFilterListAction()
    {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $usersList = $this->model->getShoppingOrderFilterList($param);
        $usersList = array_column($usersList, 'room_no', 'userid');
        $statusList = Enum_ShoppingOrder::getStatusNameList();

        $data['userlist'] = $usersList;
        $data['statuslist'] = $statusList;
        $this->echoSuccessData($data);
    }


    /**
     * 根据id获取体验购物订单详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getShoppingOrderDetailAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getShoppingOrderDetail($id);
            $data = $this->convertor->getShoppingOrderDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * update shopping order by id
     *
     * @return  echoJson
     */
    public function updateShoppingOrderByIdAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['status'] = intval($this->getParamList('status'));
            $param['adminid'] = intval($this->getParamList('adminid'));
            $param['memo'] = trim($this->getParamList('memo'));
            // status or adminid need to be set
            if ($param['status'] == 0 && $param['adminid'] == 0) {
                $this->throwException(1, 'Param lack');
            }
            $data = $this->model->updateShoppingOrderById($param, $id);
            if ($data) {
                $this->echoSuccessData($data);
            } else {
                $this->throwException(1, 'DB fail');
            }
        } else {
            $this->throwException(1, 'id不能为空');
        }
    }

    /**
     * Action for staff update orders_products manually
     */
    public function updateOrderProductByIdAction()
    {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['status'] = intval($this->getParamList('status'));
            $param['memo'] = trim($this->getParamList('memo'));
            $param['adminid'] = intval($this->getParamList('adminid'));
            $param['token'] = trim($this->getParamList('token'));

            if ($param['adminid'] <= 0) {
                $param['adminid'] = intval(Auth_Login::getToken($param['token'], 2));
                if ($param['adminid'] <= 0) {
                    $this->throwException(3, 'token已过期，请重新登录');
                }
            }

            // status or memo need to be set
            if ($param['status'] == 0 && empty($param['memo'])) {
                $this->throwException(1, 'Param lack');
            }
            $data = $this->model->updateOrderProductById($param, $id);
            if ($data) {
                $this->echoSuccessData($data);
                $this->model->notifyOrderProductStatus($id, $param['status']);
            } else {
                $this->throwException(1, 'DB fail');
            }
        } else {
            $this->throwException(1, 'id不能为空');
        }
    }

    /**
     * New action for submit shopping cart
     */
    public function addShoppingCartAction()
    {
        $param = array();
        $token = trim($this->getParamList('token'));
        $param['userid'] = Auth_Login::getToken($token);
        $products = trim($this->getParamList('products'));
        $param['products'] = json_decode($products, true);
        $param['hotelid'] = intval($this->getParamList('hotelid'));

        if (empty($param ['userid'])) {
            $this->throwException(3, '登录验证失败，请重新登录');
        }

        if (empty($param ['products']) || empty($param ['hotelid'])) {
            $this->throwException(2, '入参错误');
        }

        $order = $this->model->addShoppingCart($param);
        if (!$order) {
            $this->throwException(5, '提交失败');
        } else {
            //send message to the hotel staff
            $this->model->sendMsg($order, $param['userid'], ShoppingOrderModel::ORDER_NOTIFY_BOTH);
        }
        $this->echoSuccessData(array('orderId' => $order->id));
    }

    public function getUserOrderListAction()
    {
        $token = trim($this->getParamList('token'));
        $limit = intval($this->getParamList('limit', 10));
        $userid = Auth_Login::getToken($token);
        $hotelid = intval($this->getParamList('hotelid'));
        if (empty($userid)) {
            $this->throwException(3, '登录验证失败，请重新登录');
        }
        if (empty($hotelid)) {
            $this->throwException(3, '参数错误，hotelid');
        }
        $orderList = ShoppingOrder::with('products')
            ->where('userid', '=', $userid)
            ->where('hotelid', '=', $hotelid)
            ->where('is_delete', '=', Enum_ShoppingOrder::ORDER_NOT_DELETE)
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();
        $hotelModel = new HotelListModel();
        $hotelDetail = $hotelModel->getHotelListDetail($hotelid);
        $data = $this->convertor->appShoppingOrderList($orderList, $hotelDetail);
        $this->echoSuccessData($data);
    }

    public function getStaffOrderListAction()
    {
        $token = trim($this->getParamList('token'));
        $params['page'] = intval($this->getParamList('page', 1));
        $params['limit'] = intval($this->getParamList('limit', 10));
        $staffId = Auth_Login::getToken($token, 2);
        $hotelid = intval($this->getParamList('hotelid'));
        if (empty($staffId)) {
            $this->throwException(3, '登录验证失败，请重新登录');
        }
        if (empty($hotelid)) {
            $this->throwException(1, '参数错误，hotelid');
        }
        $staffModel = new StaffModel();
        $staffDetail = $staffModel->getStaffDetail($staffId);
        if (!in_array($hotelid, explode(Enum_System::COMMA_SEPARATOR, $staffDetail['hotel_list']))) {
            $this->throwException(3, '没有权限查看该物业');
        }
        $query = ShoppingOrder::with('products')
            ->where('hotelid', '=', $hotelid)
            ->orderBy('id', 'desc');
        if ($params['limit'] > 0) {
            $orderList = $query->paginate($params['limit'], ['*'], 'page', $params['page']);
        } else {
            $orderList = $query->get();
        }
        $hotelModel = new HotelListModel();
        $hotelDetail = $hotelModel->getHotelListDetail($hotelid);
        $data = $this->convertor->appStaffShoppingOrderList($orderList, $params['limit'], $params['page'], $hotelDetail);
        $this->echoSuccessData($data);
    }

    public function getHotelOrderListAction()
    {
        $params = array();
        $params['id'] = intval($this->getParamList('id'));
        $params['hotelid'] = intval($this->getParamList('hotelid'));
        $params['userid'] = intval($this->getParamList('userid'));
        $params['shoppingid'] = intval($this->getParamList('shoppingid'));
        $params['status'] = intval($this->getParamList('status'));
        $params['limit'] = intval($this->getParamList('limit'));
        $params['page'] = intval($this->getParamList('page'));

        $orderList = $this->model->getHotelShoppingOrderList($params);
        $hotelModel = new HotelListModel();
        $hotelDetail = $hotelModel->getHotelListDetail($params['hotelid']);
        $data = $this->convertor->staffShoppingOrderList($orderList, $params['limit'], $params['page'], $hotelDetail);
        $this->echoSuccessData($data);

    }

    /**
     * 修改订单状态
     */
    public function changeOrderStatusAction()
    {
        $param = array();
        $param ['id'] = intval($this->getParamList('orderid'));
        $param ['status'] = intval($this->getParamList('status'));
        $param ['userid'] = Auth_Login::getToken($this->getParamList('token'), 2);
        if (empty ($param ['id'])) {
            $this->throwException(2, '订单ID错误');
        }
        if (empty ($param ['userid'])) {
            $this->throwException(3, 'token验证失败');
        }
        if (!Enum_ShoppingOrder::getStatusNameList()[$param ['status']]) {
            $this->throwException(2, '订单状态错误');
        }
        // 验证订单信息
        $orderInfo = $this->model->getShoppingOrderDetail($param ['id']);
        if (empty ($orderInfo ['id'])) {
            $this->throwException(4, '订单信息错误');
        }
        if ($orderInfo ['status'] >= $param ['status']) {
            $this->throwException(6, '订单状态不可改变');
        }
        $result = $this->model->updateShoppingOrderById(array('status' => $param ['status'], 'adminid' => $param ['userid']), $param ['id']);
        if (!$result) {
            $this->throwException(5, '修改失败');
        }
        $orderInfo ['status'] = $param ['status'];
        $orderInfo ['adminid'] = $param ['userid'];
        $this->echoSuccessData($orderInfo);
    }

    /**
     * Action for user to delete shopping order from app
     */
    public function deleteOrderAction()
    {
        $param = array();
        $param['id'] = intval($this->getParamList('orderid'));
        $param['userid'] = Auth_Login::getToken($this->getParamList('token'));
        if (empty($param['id'])) {
            $this->throwException(2, '订单ID错误');
        }
        if (empty($param['userid'])) {
            $this->throwException(3, 'token验证失败');
        }

        $order = $this->model->getShoppingOrder($param['id']);
        if ($order->userid != $param['userid']) {
            $this->throwException(4, '订单信息错误');
        }

        $order->is_delete = Enum_ShoppingOrder::ORDER_MARK_DELETE;
        $order->save();
        $this->echoSuccessData($order->toArray());
    }

    /**
     * Action for get shopping hotel list
     */
    public function getShoppingHotelListAction() {
        $token = trim($this->getParamList('token'));
        $userId = Auth_Login::getToken($token);
        if (empty($userId)) {
            $this->throwException(3, 'token验证失败');
        }

        $result = $this->model->getShoppingHotelList($userId);
        $this->echoSuccessData($result);

    }

}
