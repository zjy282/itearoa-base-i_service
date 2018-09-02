<?php

/**
 * 酒店入住用户账单控制器类
 *
 */
class UserBillController extends BaseController {

    /**
     *
     * @var UserBillModel
     */
    private $model;

    /**
     *
     * @var Convertor_UserBill
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new UserBillModel();
        $this->convertor = new Convertor_UserBill();
    }

    /**
     * 获取酒店入住用户账单列表
     *
     * @return Json
     */
    public function getUserBillListAction() {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 10));
        $param['id'] = intval($this->getParamList('id'));
        $param['room_no'] = $this->getParamList('room');
        $param['name'] = $this->getParamList('name');
        $param['userid'] = intval($this->getParamList('userid'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['date'] = intval($this->getParamList('date'));
        if (Enum_System::notAdminPackage($this->package)) {
            $token = trim($this->getParamList('token'));
            $userId = Auth_Login::getToken($token);
            if (empty($userId)) {
                $this->throwException(2, 'token验证失败');
            }
            $param['userid'] = $userId;
        }
        $param['status'] = 1;
        $data = $this->model->getUserBillList($param);
        $count = $this->model->getUserBillCount($param);
        if (Enum_System::notAdminPackage($this->package)) {
            $data = $this->convertor->getUserBillListConvertor($data, $count, $param);
        } else {
            $data = $this->convertor->getUserBillListAdminConvertor($data, $count, $param);
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店入住用户账单详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getUserBillDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getUserBillDetail($id);
            $data = $this->convertor->getUserBillDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店入住用户账单信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateUserBillByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['room_no'] = $this->getParamList('room_no');
            $param ['name'] = $this->getParamList('name');
            $param ['userid'] = $this->getParamList('userid');
            $param ['pdf'] = $this->getParamList('pdf');
            $param ['date'] = $this->getParamList('date');
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updateUserBillById($param, $id);
            $data = $this->convertor->statusConvertor(array('id' => $id));
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店入住用户账单信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addUserBillAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $roomNo = trim($this->getParamList('room'));
        $name = trim($this->getParamList('name'));
        if (empty($roomNo) || empty($name)) {
            $this->throwException(2, '房间和姓名不能为空');
        }
        $userModel = new UserModel();
        $userInfo = $userModel->getUserList(array('hotelid' => $param['hotelid'], 'room_no' => $roomNo))[0];
        if (stripos($name, $userInfo['fullname']) === false) {
            $this->throwException(2, '未找到对应入住用户');
        }
        $param['room_no'] = $roomNo;
        $param['name'] = $name;
        $param['userid'] = $userInfo['id'];
        $param['pdf'] = trim($this->getParamList('pdf'));
        $param['date'] = intval($this->getParamList('date'));
        $param['status'] = 1;
        $data = $this->model->addUserBill($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 外部调用添加酒店入住用户账单信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function createUserBillAction() {
        $param = array();
        $propertyinterfId = intval($this->getParamList('propertyinterfid'));
        if (empty($propertyinterfId)) {
            $this->throwException(2, 'propertyinterfid不能为空');
        }
        $hotelListModel = new HotelListModel();
        $hotelInfo = $hotelListModel->getHotelListDetailByPropertyinterfId($propertyinterfId);
        if (empty($hotelInfo)) {
            $this->throwException(2, 'propertyinterfid错误，未找到对应物业');
        }
        $param['hotelid'] = $hotelInfo['id'];
        $roomNo = trim($this->getParamList('room'));
        $name = trim($this->getParamList('name'));
        if (empty($roomNo) || empty($name)) {
            $this->throwException(3, '房间和姓名不能为空');
        }
        $userModel = new UserModel();
        $userInfo = $userModel->getUserList(array('hotelid' => $param['hotelid'], 'room_no' => $roomNo))[0];
        if (stripos($name, $userInfo['fullname']) === false) {
            $this->throwException(3, '未找到对应入住用户');
        }
        $param['room_no'] = $roomNo;
        $param['name'] = $name;
        $param['userid'] = $userInfo['id'];
        $param['date'] = strtotime($this->getParamList('date'));
        if (empty($param['date'])) {
            $this->throwException(4, '账单时间错误');
        }
        $param['pdf'] = trim($this->getParamList('pdf'));
        if (empty($param['pdf'])) {
            $this->throwException(5, 'PDF错误');
        }
        $param['status'] = 1;
        $data = $this->model->addUserBill($param);
        if ($data) {
            $pushParams['cn_title'] = date('Ymd', $param['date']) . '账单';
            $pushParams['cn_value'] = '点击查看账单详情';
            $pushParams['en_title'] = date('Ymd', $param['date']) . 'invoice';
            $pushParams['en_value'] = 'Click to check the invoice';
            $pushParams['type'] = Enum_Push::PUSH_TYPE_USER;
            $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_URL;
            $pushParams['contentValue'] = Enum_Img::getPathByKeyAndType($param['pdf']);
            $pushParams['message_type'] = Enum_Push::PUSH_MESSAGE_TYPE_BILL;
            $pushParams['dataid'] = $param['userid'];
            $pushModel = new PushModel();
            $pushModel->addPushOne($pushParams);
        }
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
