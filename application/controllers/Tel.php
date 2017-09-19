<?php

/**
 * 酒店电话黄页控制器类
 *
 */
class TelController extends \BaseController {

    /**
     *
     * @var TelModel
     */
    private $model;

    /**
     *
     * @var Convertor_Tel
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new TelModel ();
        $this->convertor = new Convertor_Tel ();
    }

    /**
     * 获取酒店电话黄页列表
     *
     * @return Json
     */
    public function getTelListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['title'] = trim($this->getParamList('title'));
        $param ['tel'] = trim($this->getParamList('tel'));
        $param ['typeid'] = intval($this->getParamList('typeid'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getTelList($param);
        $count = $this->model->getTelCount($param);
        $data = $this->convertor->getTelListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店电话黄页详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTelDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getTelDetail($id);
            $data = $this->convertor->getTelDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改酒店电话黄页信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateTelByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['title_lang1'] = $this->getParamList('title_lang1');
            $param ['title_lang2'] = $this->getParamList('title_lang2');
            $param ['title_lang3'] = $this->getParamList('title_lang3');
            $param ['tel'] = $this->getParamList('tel');
            $param ['status'] = $this->getParamList('status');
            $param ['typeid'] = $this->getParamList('typeid');
            $data = $this->model->updateTelById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店电话黄页信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addTelAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param ['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param ['title_lang3'] = trim($this->getParamList('title_lang3'));
        $param ['tel'] = trim($this->getParamList('tel'));
        $param ['status'] = intval($this->getParamList('status'));
        $param ['typeid'] = intval($this->getParamList('typeid'));
        $data = $this->model->addTel($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 获取物业电话黄页列表
     *
     * @param
     *            int hotelid 物业ID
     * @param
     *            string token 可选，验证是否登录后可见部分
     * @return Json
     */
    public function getHotelTelListAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['islogin'] = 0;
        if (empty($param ['hotelid'])) {
            $this->throwException(6, '物业ID错误');
        }
        // 检查是否入住状态
        $token = $this->getParamList('token');
        $userId = Auth_Login::getToken($token);
        if ($userId) {
            $userModel = new UserModel ();
            $userInfo = $userModel->getUserDetail($userId);
            if ($userInfo ['hotelid'] == $param ['hotelid']) {
                unset ($param ['islogin']);
            }
        }
        $param ['status'] = 1;
        $telTypeModel = new TelTypeModel ();
        $telTypeList = $telTypeModel->getTelTypeList($param);
        $param ['status'] = 1;
        $telList = $this->model->getTelList($param);
        $result = $this->convertor->hotelTelListConvertor($telTypeList, $telList);
        $this->echoSuccessData($result);
    }
}
