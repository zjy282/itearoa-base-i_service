<?php

use Frankli\Itearoa\Models\ShoppingOrder;

/**
 * 体验购物订单转换器
 */
class Convertor_ShoppingOrder extends Convertor_Base {

    const SEPARATOR = 'A';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 体验购物订单列表
     *
     * @param array $list
     *            体验购物订单
     * @param int $count
     *            体验购物订单总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getShoppingOrderListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $statusNameList = Enum_ShoppingOrder::getStatusNameList();
        $robotStatusNameList = Enum_ShoppingOrder::getRobotStatusNameList();

        $userIdList = array_column($list, 'userid');
        if ($userIdList) {
            $userModel = new UserModel();
            $userInfoList = $userModel->getUserList(array('id' => $userIdList));
            $userInfoList = array_column($userInfoList, null, 'id');
        }

        $shoppingIdList = array_column($list, 'shoppingid');
        if ($shoppingIdList) {
            $shoppingModel = new ShoppingModel();
            $shoppingInfoList = $shoppingModel->getShoppingList(array('id' => $shoppingIdList));
            $shoppingInfoList = array_column($shoppingInfoList, null, 'id');
        }

        $adminIdList = array_column($list, 'adminid');
        if ($adminIdList) {
            $staffModel = new StaffModel();
            $staffInfoList = $staffModel->getStaffList(array('id' => $adminIdList));
            $staffInfoList = array_column($staffInfoList, null, 'id');
        }

        foreach ($list as $listOne) {
            $listOneTemp = array();
            $listOneTemp ['id'] = $listOne ['id'];
            $listOneTemp ['userid'] = $listOne ['userid'];
            $listOneTemp ['count'] = $listOne ['count'];
            $listOneTemp ['createtime'] = $listOne ['creattime'];
            $listOneTemp ['status'] = $listOne ['status'];
            $listOneTemp ['statusName'] = $statusNameList [$listOne ['status']];
            $listOneTemp ['robotStatusName'] = $robotStatusNameList [$listOne['robot_status']];
            $listOneTemp ['shoppingid'] = $listOne ['shoppingid'];
            $listOneTemp ['adminid'] = $listOne ['adminid'];
            $userInfoTemp = $userInfoList[$listOneTemp['userid']];
            $listOneTemp['userInfo'] = array(
                'name' => $userInfoTemp['fullname'],
                'room' => $userInfoTemp['room_no']
            );
            $shoppingInfoTemp = $shoppingInfoList[$listOneTemp['shoppingid']];
            $listOneTemp['shoppingInfo'] = array(
                'name' => $this->handlerMultiLang('title', $shoppingInfoTemp),
                'introduct' => $this->handlerMultiLang('introduct', $shoppingInfoTemp),
                'pic' => Enum_Img::getPathByKeyAndType($shoppingInfoTemp['pic']),
                'detail' => $this->handlerMultiLang('detail', $shoppingInfoTemp),
                'pdf' => Enum_Img::getPathByKeyAndType($shoppingInfoTemp['pdf']),
                'video' => Enum_Img::getPathByKeyAndType($shoppingInfoTemp['video']),
                'price' => floatval($shoppingInfoTemp['price'])
            );
            $staffInfoListTemp = $staffInfoList[$listOneTemp['adminid']];
            if ($listOneTemp['adminid']) {
                $listOneTemp['staffInfo'] = array(
                    'name' => $staffInfoListTemp['lname']
                );
            }
            $data ['list'] [] = $listOneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 后台体验购物订单列表
     *
     * @param array $list
     *            体验购物订单
     * @param int $count
     *            体验购物订单总数
     * @param array $param
     *            扩展参数
     * @return array
     */
    public function getOrderListConvertor($list, $count, $param) {
        $data = array('list' => array());
        $shoppingIdList = array_column($list, 'shoppingid');
        $shoppingModel = new ShoppingModel ();
        $shoppingInfoList = $shoppingModel->getShoppingList(array('id' => $shoppingIdList));
        $shoppingNameList = array_column($shoppingInfoList, 'title_lang1', 'id');
        $adminIdList = array_column($list, 'adminid');
        if ($adminIdList) {
            $staffModel = new StaffModel ();
            $adminInfoList = $staffModel->getStaffList(array('id' => $adminIdList));
            $adminNameList = array_column($adminInfoList, 'lname', 'id');
        }
        $statusNameList = Enum_ShoppingOrder::getStatusNameList();
        $robotStatusNameList = Enum_ShoppingOrder::getRobotStatusNameList();

        $userIdList = array_column($list, 'userid');
        if ($userIdList) {
            $userModel = new UserModel();
            $userInfoList = $userModel->getUserList(array('id' => $userIdList));
            $userInfoList = array_column($userInfoList, null, 'id');
        }

        foreach ($list as $listOne) {
            $listOneTemp = array();
            $listOneTemp ['id'] = $listOne ['id'];
            $listOneTemp ['userid'] = $listOne ['userid'];
            $userInfoTemp = $userInfoList[$listOneTemp['userid']];
            $listOneTemp['userInfo'] = array(
                'name' => $userInfoTemp['fullname'],
                'room' => $userInfoTemp['room_no']
            );
            $listOneTemp ['count'] = $listOne ['count'];
            $listOneTemp ['createtime'] = $listOne ['creattime'];
            $listOneTemp ['status'] = $listOne ['status'];
            $listOneTemp ['statusName'] = $statusNameList [$listOne ['status']];
            $listOneTemp ['robotStatus'] = $listOne ['robot_status'];
            $listOneTemp ['robotStatusName'] = $robotStatusNameList [$listOne['robot_status']];
            $listOneTemp ['shoppingid'] = $listOne ['shoppingid'];
            $listOneTemp ['shoppingName'] = $shoppingNameList [$listOne ['shoppingid']];
            $listOneTemp ['adminid'] = $listOne ['adminid'];
            $listOneTemp['memo'] = $listOne['memo'];
            $listOneTemp ['adminName'] = $adminNameList [$listOne ['adminid']];
            $data ['list'] [] = $listOneTemp;
        }
        $data ['total'] = $count;
        $data ['page'] = $param ['page'];
        $data ['limit'] = $param ['limit'];
        $data ['nextPage'] = Util_Tools::getNextPage($data ['page'], $data ['limit'], $data ['total']);
        return $data;
    }

    /**
     * 获取订单详情
     * @param $data
     * @return array
     */
    public function getShoppingOrderDetail($data) {
        $result = array();
        $statusNameList = Enum_ShoppingOrder::getStatusNameList();
        $result['id'] = $data['id'];
        $result['userId'] = $data['userid'];
        $userModel = new UserModel();
        $userInfo = $userModel->getUserDetail($result['userId']);
        $result['userInfo'] = array(
            'name' => $userInfo['fullname']
        );
        $result['count'] = $data['count'];
        $result['createTime'] = $data['creattime'];
        $result['hotelid'] = $data['hotelid'];
        $result['status'] = $data['status'];
        $result['statusShow'] = $statusNameList[$data['status']];
        $result['adminId'] = $data['adminid'];
        if ($result['adminId']) {
            $staffModel = new StaffModel();
            $staffInfo = $staffModel->getStaffDetail($result['adminId']);
            $result['staffInfo'] = array(
                'name' => $staffInfo['lname']
            );
        }
        $result['shoppingId'] = $data['shoppingid'];
        $shoppingModel = new ShoppingModel();
        $shoppingInfo = $shoppingModel->getShoppingDetail($result['shoppingId']);
        $result['shoppingInfo'] = array(
            'name' => $this->handlerMultiLang('title', $shoppingInfo),
            'introduct' => $this->handlerMultiLang('introduct', $shoppingInfo),
            'pic' => Enum_Img::getPathByKeyAndType($shoppingInfo['pic']),
            'detail' => $this->handlerMultiLang('detail', $shoppingInfo),
            'pdf' => Enum_Img::getPathByKeyAndType($shoppingInfo['pdf']),
            'video' => Enum_Img::getPathByKeyAndType($shoppingInfo['video']),
            'price' => floatval($shoppingInfo['price'])
        );
        return $result;
    }

    /**
     * For webview display of APP
     *
     * @param $orderList
     * @return array
     */
    public function appShoppingOrderList($orderList, $hotelDetail): array
    {
        $result = array();
        $statusNameList = Enum_ShoppingOrder::getStatusNameList(self::getLang(false));
        /**
         * @var ShoppingOrder $order
         */
        foreach ($orderList as $order) {
            $item = array();
            $item['id'] = $order->id;
            $item['id_show'] = self::encodeId($order->id, $hotelDetail['id'], $hotelDetail['propertyinterfid']);
            $item['status'] = $statusNameList[$order->status];
            $item['num'] = count($order->products);
            $item['created_at'] = $order->created_at;
            $price = 0;
            $products = array();
            foreach ($order->products as $product) {
                $tmpProduct = array();
                $tmpProduct['title'] = $this->handlerMultiLang('title', $product);
                $tmpProduct['pic'] = Enum_Img::getPathByKeyAndType($product->pic);
                $tmpProduct['num'] = $product->pivot->count;
                if ($product->pivot->status == Enum_ShoppingOrder::ORDER_STATUS_CANCEL) {
                    $tmpProduct['price'] = 0;
                } else {
                    $tmpProduct['price'] = floatval($product->price) * $product->pivot->count;
                }
                $tmpProduct['status'] = $statusNameList[$product->pivot->status];
                $price += $tmpProduct['price'];
                $products[] = $tmpProduct;
            }
            $item['products'] = $products;
            $item['price'] = $price;
            $result[] = $item;
        }
        return $result;
    }


    /**
     * For webview display of staff order list
     *
     * @param $orderList
     * @param $limit
     * @param $page
     * @return array
     */
    public function appStaffShoppingOrderList($orderList, $limit, $page, $hotelDetail): array
    {
        $result = array();
        $data = array();
        $statusNameList = Enum_ShoppingOrder::getStatusNameList(self::getLang(false));
        /**
         * @var ShoppingOrder $order
         */
        foreach ($orderList as $order) {
            $item = array();
            $item['id'] = $order->id;
            $item['room_no'] = $order->user->room_no;
            $item['id_show'] = self::encodeId($order->id, $hotelDetail['id'], $hotelDetail['propertyinterfid']);
            $item['status'] = $statusNameList[$order->status];
            $item['num'] = count($order->products);
            $item['created_at'] = $order->created_at;
            $price = 0;
            $products = array();
            foreach ($order->products as $product) {
                $tmpProduct = array();
                $tmpProduct['orders_products_id'] = $product->pivot->id;
                $tmpProduct['title'] = $this->handlerMultiLang('title', $product);
                $tmpProduct['pic'] = Enum_Img::getPathByKeyAndType($product->pic);
                $tmpProduct['num'] = $product->pivot->count;
                if ($product->pivot->status == Enum_ShoppingOrder::ORDER_STATUS_CANCEL) {
                    $tmpProduct['price'] = 0;
                } else {
                    $tmpProduct['price'] = floatval($product->price) * $product->pivot->count;
                }
                $tmpProduct['status'] = $statusNameList[$product->pivot->status];
                $tmpProduct['productStatus'] = $product->pivot->status;
                $price += $tmpProduct['price'];
                $products[] = $tmpProduct;
            }
            $item['products'] = $products;
            $item['price'] = $price;
            $data[] = $item;
        }
        $result['list'] = $data;
        if ($limit > 0) {
            $result['total'] = $orderList->total();
            $result['limit'] = $limit;
            $result['page'] = $page;
            $result['nextPage'] = Util_Tools::getNextPage($result['page'], $limit, $result['total']);
        }
        return $result;
    }

    /**
     * For staff admin website
     *
     * @param $orderList
     * @param $limit
     * @param $page
     * @return array
     */
    public function staffShoppingOrderList($orderList, $limit, $page, $hotelDetail): array
    {
        $result = array();
        $langIndex = self::getLang();
        $statusNameList = Enum_ShoppingOrder::getStatusNameList(self::getLang(false));
        $robotStatusNameList = Enum_ShoppingOrder::getRobotStatusNameList(self::getLang(false));
        $data = array();
        foreach ($orderList as $order) {
            $item = array();
            $item['idShow'] = self::encodeId($order->id, $hotelDetail['id'], $hotelDetail['propertyinterfid']);
            $item['id'] = $order->id;
            $item['userid'] = $order->userid;
            $item['userInfo'] = array(
                'name' => $order->user->fullname,
                'room' => $order->user->room_no
            );
            $item['adminName'] = $order->staff->lname;
            $item['adminid'] = $order->adminid;
            $item['createtime'] = $order->created_at;
            $item['status'] = $order->status;
            $item['statusName'] = $statusNameList[$item['status']];

            foreach ($order->products as $product) {
                $item['orders_products_id'] = $product->pivot->id;
                $item['memo'] = $product->pivot->memo;
                $key = 'title_lang' . $langIndex;
                $item['shoppingName'] = $product->{$key};
                $item['productStatus'] = $product->pivot->status;
                $item['productStatusName'] = $statusNameList[$item['productStatus']];
                $item['robotStatus'] = $product->pivot->robot_status;
                $item['robotStatusName'] = $robotStatusNameList[$item['robotStatus']];
                $item['count'] = $product->pivot->count;
                if ($product->pivot->status == Enum_ShoppingOrder::ORDER_STATUS_CANCEL) {
                    $item['price'] = 0;
                } else {
                    $item['price'] = floatval($product->price) * $product->pivot->count;
                }
                $data[] = $item;
            }
        }
        $result['list'] = $data;

        if ($limit > 0) {
            $result['total'] = $orderList->total();
            $result['limit'] = $limit;
            $result['page'] = $page;
            $result['nextPage'] = Util_Tools::getNextPage($result['page'], $limit, $result['total']);
        }
        return $result;

    }

    /**
     * @param int $id
     * @param int $hotelid
     * @param int $propertyId
     * @return string
     */
    public static function encodeId(int $id, int $hotelid, int $propertyId): string
    {
        return $hotelid . $propertyId . self::SEPARATOR . $id;
    }

    /**
     * @param string $mark
     * @return int
     */
    public static function decodeId(string $mark): int
    {
        $pos = strpos($mark, self::SEPARATOR);
        return intval(substr($mark, $pos + 1));
    }
}