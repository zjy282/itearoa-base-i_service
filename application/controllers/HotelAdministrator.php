<?php

/**
 * 物业管理员控制器类
 */
class HotelAdministratorController extends \BaseController {

    /**
     * @var HotelAdministratorModel
     */
    private $model;
    /**
     * @var Convertor_HotelAdministrator
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new HotelAdministratorModel();
        $this->convertor = new Convertor_HotelAdministrator();
    }

    /**
     * 获取HotelAdministrator列表
     *
     * @return Json
     */
    public function getHotelAdministratorListAction() {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 5));
        $param['id'] = intval($this->getParamList('id'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['username'] = trim($this->getParamList('username'));
        $param['status'] = $this->getParamList('status');
        if (is_null($param['status'])) {
            unset($param['status']);
        }
        $data = $this->model->getHotelAdministratorList($param);
        $count = $this->model->getHotelAdministratorCount($param);
        $data = $this->convertor->getHotelAdministratorListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }


    /**
     * 根据id获取HotelAdministrator详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getHotelAdministratorDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getHotelAdministratorDetail($id);
            $data = $this->convertor->getHotelAdministratorDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改HotelAdministrator信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateHotelAdministratorByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $paramList = $this->getParamList();
            $param = array();
            $paramList['username'] ? $param['userName'] = trim($paramList['username']) : false;
            $paramList['password'] ? $param['password'] = md5(trim($paramList['password'])) : false;
            $paramList['realname'] ? $param['realName'] = trim($paramList['realname']) : false;
            $paramList['remark'] ? $param['remark'] = trim($paramList['remark']) : false;
            isset($paramList['status']) ? $param['status'] = intval($paramList['status']) : false;
            isset($paramList['hotelid']) ? $param['hotelId'] = trim($paramList['hotelid']) : false;
            $data = $this->model->updateHotelAdministratorById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加HotelAdministrator信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addHotelAdministratorAction() {
        $param = array();
        $param['userName'] = trim($this->getParamList('username'));
        $param['password'] = md5(trim($this->getParamList('password')));
        $param['realName'] = trim($this->getParamList('realname'));
        $param['remark'] = trim($this->getParamList('remark'));
        $param['status'] = intval($this->getParamList('status'));
        $param['hotelId'] = intval($this->getParamList('hotelid'));
        $param['createAdmin'] = intval($this->getParamList('createadmin'));
        $param['createTime'] = time();
        $data = $this->model->addHotelAdministrator($param);
        $data = $this->convertor->statusConvertor(array(
            'id' => $data
        ));
        $this->echoSuccessData($data);
    }

}
