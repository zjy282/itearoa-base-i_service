<?php

/**
 * 酒店房间控制器类
 *
 */
class RoomController extends \BaseController {

    /**
     *
     * @var RoomModel
     */
    private $model;

    /**
     *
     * @var Convertor_Room
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new RoomModel ();
        $this->convertor = new Convertor_Room ();
    }

    /**
     * 获取酒店房间列表
     *
     * @return Json
     */
    public function getRoomListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['room'] = $this->getParamList('room');
        $param ['floor'] = $this->getParamList('floor');
        $param ['size'] = $this->getParamList('size');
        $param ['typeid'] = $this->getParamList('typeid');
        $data = $this->model->getRoomList($param);
        $count = $this->model->getRoomCount($param);
        $data = $this->convertor->getRoomListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取酒店房间详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getRoomDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getRoomDetail($id);
            $data = $this->convertor->getRoomDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改酒店房间信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateRoomByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['hotelid'] = $this->getParamList('hotelid');
            $param ['floor'] = $this->getParamList('floor');
            $param ['room'] = $this->getParamList('room');
            $param ['typeid'] = $this->getParamList('typeid');
            $param ['size'] = $this->getParamList('size');
            $data = $this->model->updateRoomById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加酒店房间信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addRoomAction() {
        $param = array();
        $param ['hotelid'] = $this->getParamList('hotelid');
        $param ['floor'] = $this->getParamList('floor');
        $param ['room'] = $this->getParamList('room');
        $param ['typeid'] = $this->getParamList('typeid');
        $param ['size'] = $this->getParamList('size');
        $param ['createtime'] = time();
        $data = $this->model->addRoom($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
