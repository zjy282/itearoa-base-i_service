<?php

use Frankli\Itearoa\Models\ShoppingOrder;
use Frankli\Itearoa\Models\ShoppingProduct;
use Frankli\Itearoa\Models\Staff;
use Frankli\Itearoa\Models\ShoppingCategory;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Class ShoppingOrderModel
 * 购物订单管理Model
 */
class ShoppingOrderModel extends \BaseModel
{

    const ORDER_NOTIFY_EMAIL = 1;
    const ORDER_NOTIFY_MSG = 2;
    const ORDER_NOTIFY_BOTH = 3;

    const ERROR_SHOPPING_PERMISSION = 4;
    const ERROR_SHOPPING_PERMISSION_MSG = '请选择已入住物业进行购买';


    private $dao;

    public function __construct()
    {
        parent::__construct();
        $this->dao = new Dao_ShoppingOrder();
    }

    /**
     * 获取ShoppingOrder列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingOrderList(array $param)
    {
        $paramList = array();
        $param['shoppingid'] ? $paramList['shoppingid'] = strval($param['shoppingid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['userid'] ? $paramList['userid'] = intval($param['userid']) : false;
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        $param['status'] ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShoppingOrderList($paramList);
    }

    /**
     * Get filter field info for shopping order
     *
     * @param array $param
     * @return array
     */
    public function getShoppingOrderFilterList(array $param): array
    {
        $paramList = array();
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        return $this->dao->getShoppingOrderFilter($paramList);
    }

    /**
     * 获取ShoppingOrder数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShoppingOrderCount(array $param)
    {
        $paramList = array();
        $param['shoppingid'] ? $paramList['shoppingid'] = strval($param['shoppingid']) : false;
        $param['hotelid'] ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $param['userid'] ? $paramList['userid'] = intval($param['userid']) : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getShoppingOrderCount($paramList);
    }

    /**
     * 根据id查询ShoppingOrder信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShoppingOrderDetail($id)
    {
        $result = array();
        if ($id) {
            $result = $this->dao->getShoppingOrderDetail($id);
        }
        return $result;
    }

    /**
     * @param $id
     * @return ShoppingOrder
     */
    public function getShoppingOrder($id)
    {
        $shoppingOrder = ShoppingOrder::findOrFail($id);
        return $shoppingOrder;
    }

    /**
     * Get all the hotel list where the user has purchased
     *
     * @param int $userid
     * @return array
     */
    public function getShoppingHotelList(int $userid): array
    {
        $orderList = ShoppingOrder::where('userid', '=', $userid)->get()->toArray();
        $hotelIdArray = array_unique(array_column($orderList, 'hotelid'));
        $hotelDao = new Dao_HotelList();
        $hotelList = $hotelDao->getHotelListList(array('id' => $hotelIdArray));

        $result = array();
        foreach ($hotelList as $hotel) {
            $tmpHotel = array();
            $tmpHotel['id'] = $hotel['id'];
            $tmpHotel['name_lang1'] = $hotel['name_lang1'];
            $tmpHotel['name_lang2'] = $hotel['name_lang2'];
            $tmpHotel['name_lang3'] = $hotel['name_lang3'];
            $result[] = $tmpHotel;
        }
        return $result;
    }

    /**
     * 根据id更新ShoppingOrder信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShoppingOrderById($param, $id)
    {
        $result = false;
        if ($id) {
            $info = array();
            $param['status'] ? $info['status'] = $param['status'] : false;
            $param['adminid'] ? $info['adminid'] = $param['adminid'] : false;
            $param['memo'] ? $info['memo'] = $param['memo'] : false;
            $result = $this->dao->updateShoppingOrderById($info, $id);
        }
        return $result;
    }

    /**
     * @param array $param
     * @param int $id
     * @return bool|int
     */
    public function updateOrderProductById(array $param, int $id)
    {
        $result = false;
        if ($id) {
            $info = array();
            $param['status'] ? $info['status'] = $param['status'] : false;
            $param['adminid'] ? $info['adminid'] = $param['adminid'] : false;
            if (empty($param['memo'])) {
                $staff = Staff::find($param['adminid']);
                if ($staff) {
                    $info['memo'] = $staff->lname;
                }
            } else {
                $info['memo'] = $param['memo'];
            }
            $result = DB::table('orders_products')->where('id', '=', $id)->update($info);
            $orderProduct = DB::table('orders_products')->find($id);
            if ($orderProduct->order_id) {
                ShoppingOrderModel::syncOrder(array($orderProduct->order_id));

            }
        }
        return $result;
    }

    /**
     * Send app notice to user for the order status update
     *
     * @param int $orderProductId
     * @param int $status
     */
    public function notifyOrderProductStatus(int $orderProductId, int $status)
    {
        $pushModel = new PushModel();
        $orderProduct = DB::table('orders_products')->find($orderProductId);
        $order = ShoppingOrder::findOrFail($orderProduct->order_id);
        $product = ShoppingProduct::findOrFail($orderProduct->product_id);

        $content = "订单状态更新：" . $product->title_lang1 . " -> " . Enum_ShoppingOrder::getStatusName($status, Enum_Lang::CHINESE);
        $enContent = "Shopping Order Status Update: " . $product->title_lang2 . " -> " . Enum_ShoppingOrder::getStatusName($status, Enum_Lang::ENGLISH);

        $pushParams['cn_title'] = Enum_Push::PUSH_SHOPPING_ORDER_TITLE_ZH;
        $pushParams['cn_value'] = $content;
        $pushParams['en_title'] = Enum_Push::PUSH_SHOPPING_ORDER_TITLE_EN;
        $pushParams['en_value'] = $enContent;
        $pushParams['type'] = Enum_Push::PUSH_TYPE_USER;
        $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
        $pushParams['contentValue'] = $orderProductId;
        $pushParams['message_type'] = Enum_Push::PUSH_MESSAGE_TYPE_SHOPPING;
        $pushParams['dataid'] = $order->userid;

        $pushModel->addPushOne($pushParams);
    }

    /**
     * @param array $param
     * @return ShoppingOrder
     * @throws Exception
     */
    public function addShoppingCart(array $param)
    {
        $this->verifyRequest($param);
        $userDao = new Dao_User();
        $userDetail = $userDao->getUserDetail($param['userid']);
        if (empty($userDetail) || $userDetail['hotelid'] != $param['hotelid']) {
            $this->throwException(self::ERROR_SHOPPING_PERMISSION_MSG, self::ERROR_SHOPPING_PERMISSION);
        }


        $orderArray = array();
        $orderArray['userid'] = $param['userid'];
        $orderArray['hotelid'] = $param['hotelid'];
        $orderArray['created_at'] = time();
        $orderArray['status'] = Enum_ShoppingOrder::ORDER_STATUS_WAIT;
        try {
            DB::beginTransaction();
            $order = ShoppingOrder::create($orderArray);
            $orderProductArray = array();
            foreach ($param['products'] as $product) {
                $orderProduct = array();
                $orderProduct['order_id'] = $order->id;
                $orderProduct['product_id'] = $product['id'];
                $orderProduct['count'] = $product['num'];
                $orderProduct['status'] = Enum_ShoppingOrder::ORDER_STATUS_WAIT;
                $orderProduct['robot_status'] = Enum_ShoppingOrder::ROBOT_WAITING;
                $orderProduct['updated_at'] = $orderArray['created_at'];
                array_push($orderProductArray, $orderProduct);
            }
            ShoppingOrder::addProducts($orderProductArray);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function sendMsg(ShoppingOrder $order, int $userid, $type = self::ORDER_NOTIFY_EMAIL)
    {
        $userDao = new Dao_User();
        $userDetail = $userDao->getUserDetail($userid);
        $shoppingContent = '';
        $totalPrice = 0;
        foreach ($order->products as $product) {
            $name = $product->title_lang1;
            $price = floatval($product->price);
            $count = intval($product->pivot->count);
            $shoppingContent = $shoppingContent . sprintf("<p>定单：%s X %s</p>", $name, $count);
            $totalPrice += ($price * $count);
        }

        $mailTemplate = "
        <head>
            <meta charset=\"UTF-8\">
        </head>
           <p>客房：%s</p> 
           <p>房客：%s</p> 
           %s
           <p>下单时间： %s</p>
           <p>总价：%.2f</p>
           <br>
           <a href='https://staff.easyiservice.com/shopping/order'>处理订单</a>
        </body>
        ";

        $mailContent = sprintf($mailTemplate, $userDetail['room_no'], $userDetail['fullname'],
            $shoppingContent,
            date("Y-m-d H:i:s", $order->created_at),
            $totalPrice
        );
        $subject = "体验购物定单：" . $userDetail['room_no'] . " - 定单号：" . $order->id;
        $enSubject = "Shopping Order: " . $userDetail['room_no'] . " - Order No.: " . $order->id;

        $staffIdList = ShoppingOrderModel::getOrderStaffList(array($order->id));
        $staffArray = Staff::whereIn('id', $staffIdList)->get();
        if ($type == self::ORDER_NOTIFY_MSG || $type == self::ORDER_NOTIFY_BOTH) {
            //send app message to staff
            $pushParams['cn_title'] = $subject;
            $pushParams['cn_value'] = '点击查看订单详情';
            $pushParams['en_title'] = $enSubject;
            $pushParams['en_value'] = 'Click to check the order';
            $pushParams['type'] = Enum_Push::PUSH_TYPE_STAFF;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
            $pushParams['contentValue'] = $order->id;
            $pushModel = new PushModel();

            if (count($staffArray) > 0) {
                foreach ($staffArray as $staff) {
                    if (PushModel::checkSchedule($staff->schedule, time())) {
                        $pushParams['dataid'] = $staff['id'];
                        $pushModel->addPushOne($pushParams);
                    }
                }
            }
        }

        $to = array();
        foreach ($staffArray as $staff) {
            if (PushModel::checkSchedule($staff->schedule, time())) {
                if (!empty($staff->email)) {
                    $to[$staff->email] = $staff->lname;
                }
            }
        }
        if (($type == self::ORDER_NOTIFY_EMAIL || $type == self::ORDER_NOTIFY_BOTH) && !empty($to)) {
            //send email message to staff
            $smtp = Mail_Email::getInstance();
            $smtp->addCc('iservice@liheinfo.com');
            $smtp->send($to, $subject, $mailContent);
        }

        return true;
    }

    public function getHotelShoppingOrderList(array $params)
    {
        $paramList = array();
        $params['id'] ? $paramList['id'] = $params['id'] : false;
        $params['hotelid'] ? $paramList['hotelid'] = $params['hotelid'] : false;
        $params['userid'] ? $paramList['userid'] = $params['userid'] : false;
        $params['status'] ? $paramList['status'] = $params['status'] : false;


        $withArray = array('user', 'staff');
        $productId = $params['shoppingid'] ? intval($params['shoppingid']) : false;
        if ($productId) {
            $callback = function ($query) use ($productId) {
                $query->where('product_id', '=', $productId);
            };
            $withArray['products'] = $callback;
        } else {
            $callback = null;
            array_push($withArray, 'products');
        }
        $query = ShoppingOrder::with($withArray);
        $query->whereHas('products', $callback);

        if (!empty($paramList)) {
            $query->where($paramList);
        }

        $query->orderBy('id', 'desc');

        if ($params['limit'] > 0) {
            return $query->paginate($params['limit'], ['*'], 'page', $params['page']);
        } else {
            return $query->get();
        }
    }

    /**
     * Verify the interval of the request
     *
     * @param array $request
     * @param int $timeout
     */
    private function verifyRequest(array $request, int $timeout = 5)
    {
        $errNo = 1;
        $value = 1;
        if ($timeout <= 0) {
            $this->throwException("timeout must be larger than 0", $errNo);
        }
        $redis = Cache_Redis::getInstance();
        $key = json_encode($request);
        $key = md5($key);
        if ($redis->get($key) == $value) {
            $this->throwException("equest too frequent, wait $timeout second", $errNo);
        } else {
            $redis->set($key, $value, $timeout);
        }
    }

    /**
     * Update the order status when all products have the same status
     *
     * @param array $orderIdArray
     */
    public static function syncOrder(array $orderIdArray)
    {
        $orders = ShoppingOrder::with('user', 'products')->whereIn('id', $orderIdArray)->get();
        foreach ($orders as $order) {
            $flag = true;
            $status = null;
            foreach ($order->products as $product) {
                if ($product->pivot->status == Enum_ShoppingOrder::ORDER_STATUS_CANCEL) {
                    continue;
                }
                if (is_null($status)) {
                    $status = $product->pivot->status;
                    continue;
                }
                if ($status != $product->pivot->status) {
                    $flag = false;
                    break;
                }
            }

            if ($flag) {
                if (is_null($status)) {
                    //mark as complete if all items are cancelled
                    $status = Enum_ShoppingOrder::ORDER_STATUS_COMPLETE;
                }
                $order->status = $status;
                $order->save();
            }
        }
    }

    /**
     * @param array $orderId
     * @return array
     */
    public static function getOrderStaffList(array $orderIdArray): array {
        $result = array();
        $orderArray = ShoppingOrder::whereIn('id', $orderIdArray)->get();
        if (count($orderArray) == 0) {
            return $result;
        }
        $tagIdArray = array();
        foreach ($orderArray as $order){
            foreach ($order->products as $product){
                $tagIdArray[] = $product->tagid;
            }
        }
        $tagIdArray = array_unique($tagIdArray);
        $tagArray = ShoppingCategory::whereIn('id', $tagIdArray)->get();
        foreach ($tagArray as $tag) {
            if (!empty($tag->staff_list)) {
                $result = array_merge($result, explode(Enum_System::COMMA_SEPARATOR, $tag->staff_list));
            }
        }
        return $result;
    }

}
