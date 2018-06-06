<?php

use Frankli\Itearoa\Models\ShoppingOrder;
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
            $param['memo'] ? $info['memo'] = $param['memo'] : false;
            $result = DB::table('orders_products')->where('id', '=', $id)->update($info);
            $orderProduct = DB::table('orders_products')->find($id);
            if ($orderProduct->order_id) {
                ShoppingOrder::syncOrder(array($orderProduct->order_id));

            }
        }
        return $result;
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
            $staffModel = new StaffModel();
            $pushStaffIds = $staffModel->getStaffList(array(
                'hotelid' => $userDetail['hotelid']
            ));

            if ($pushStaffIds) {
                foreach ($pushStaffIds as $staff) {
                    $pushParams['dataid'] = $staff['id'];
                    $pushModel->addPushOne($pushParams);
                }
            }
        }

        $to = $this->getEmailArray($userDetail['hotelid']);
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
     * Send the detail of the order to manager
     *
     * @param array $info
     * @return bool
     */
    public function sendOrderMsg($info, $type = self::ORDER_NOTIFY_EMAIL)
    {
        $shoppingDao = new Dao_Shopping();
        $userDao = new Dao_User();
        $userDetail = $userDao->getUserDetail($info['userid']);
        $shoppingDetail = $shoppingDao->getShoppingDetail($info['shoppingid']);
        $shoppingDetail['url'] = Enum_Img::getPathByKeyAndType($shoppingDetail ['pic'], Enum_Img::PIC_TYPE_KEY_WIDTH750);

        $mailTemplate = "
        <head>
            <meta charset=\"UTF-8\">
        </head>
           <p>客房：%s</p> 
           <p>房客：%s</p> 
           <p>定单：%s X %s</p> 
           <p>下单时间： %s</p>
           <p>价格：%s</p>
           <p><img src='%s'/></p>
           
        </body>
        ";

        $mailContent = sprintf($mailTemplate, $userDetail['room_no'], $userDetail['fullname'],
            $shoppingDetail['title_lang1'], $info['count'],
            date("Y-m-d H:i:s", $info['creattime']),
            $shoppingDetail['price'],
            $shoppingDetail['url']
        );
        $subject = "体验购物定单：" . $userDetail['room_no'] . " - " . $shoppingDetail['title_lang1'] . " X " . $info['count'];
        $enSubject = "Shopping Order: " . $userDetail['room_no'] . " - " . $shoppingDetail['title_lang2'] . " X " . $info['count'];

        if ($type == self::ORDER_NOTIFY_MSG || $type == self::ORDER_NOTIFY_BOTH) {
            //send app message to staff
            $pushParams['cn_title'] = $subject;
            $pushParams['cn_value'] = '点击查看订单详情';
            $pushParams['en_title'] = $enSubject;
            $pushParams['en_value'] = 'Click to check the order';
            $pushParams['type'] = Enum_Push::PUSH_TYPE_STAFF;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_SHOPPING_ORDER;
            $pushParams['contentValue'] = $info['id'];
            $pushModel = new PushModel();
            $staffModel = new StaffModel();
            $pushStaffIds = $staffModel->getStaffList(array(
                'hotelid' => $info['hotelid']
            ));

            if ($pushStaffIds) {
                foreach ($pushStaffIds as $staff) {
                    $pushParams['dataid'] = $staff['id'];
                    $pushModel->addPushOne($pushParams);
                }
            }
        }

        $to = $this->getEmailArray($info['hotelid']);
        if (($type == self::ORDER_NOTIFY_EMAIL || $type == self::ORDER_NOTIFY_BOTH) && !empty($to)) {
            //send email message to staff
            $smtp = Mail_Email::getInstance();
            $smtp->addCc('iservice@liheinfo.com');
            $smtp->send($to, $subject, $mailContent);
        }

        return true;
    }


    /**
     * @param $hotelId
     * @return array|null
     */
    public function getEmailArray($hotelId)
    {
        $data = array(
            1 => array(
                'amanda.li@the-ascott.com' => 'amanda.li',
                'frontoffice.arcb@the-ascott.com' => 'rontoffice.arcb',
                'lewis.liu@the-ascott.com' => 'lewis.liu',
                'miki.wu@the-ascott.com' => 'miki.wu',
                'tracy.han@the-ascott.com' => 'tracy.han',
            ),
            6 => array(
                'fangzhou@liheinfo.com' => 'Fangzhou',
                'frank@itearoa.co.nz' => 'Frank'
            ),
            7 => array(
                'summer.li@the-ascott.com' => '李云云',
                'bobo.wu@the-ascott.com' => '伍宝琴',
                'jennifer.wang@the-ascott.com' => '王奋',
                'frontoffice.aifcg@the-ascott.com' => '前台',
            ),
            26 => array(
                'fangzhou@liheinfo.com' => 'Fangzhou',
                'frank@itearoa.co.nz' => 'frank'
            ),
        );

        return $data[$hotelId];
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

}
