<?php

/**
 * 体验购物订单转换器
 */
class Convertor_ShoppingOrder extends Convertor_Base {

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
        foreach ($list as $listOne) {
            $listOneTemp = array();
            $listOneTemp ['id'] = $listOne ['id'];
            $listOneTemp ['userid'] = $listOne ['userid'];
            $listOneTemp ['count'] = $listOne ['count'];
            $listOneTemp ['createtime'] = $listOne ['creattime'];
            $listOneTemp ['status'] = $listOne ['status'];
            $listOneTemp ['statusName'] = $statusNameList [$listOne ['status']];
            $listOneTemp ['shoppingid'] = $listOne ['shoppingid'];
            $listOneTemp ['adminid'] = $listOne ['adminid'];
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
        foreach ($list as $listOne) {
            $listOneTemp = array();
            $listOneTemp ['id'] = $listOne ['id'];
            $listOneTemp ['userid'] = $listOne ['userid'];
            $listOneTemp ['count'] = $listOne ['count'];
            $listOneTemp ['createtime'] = $listOne ['creattime'];
            $listOneTemp ['status'] = $listOne ['status'];
            $listOneTemp ['statusName'] = $statusNameList [$listOne ['status']];
            $listOneTemp ['shoppingid'] = $listOne ['shoppingid'];
            $listOneTemp ['shoppingName'] = $shoppingNameList [$listOne ['shoppingid']];
            $listOneTemp ['adminid'] = $listOne ['adminid'];
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
}