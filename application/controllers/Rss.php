<?php

/**
 * RSS控制器类
 *
 */
class RssController extends BaseController {

    /**
     *
     * @var RssModel
     */
    private $model;

    /**
     *
     * @var Convertor_Rss
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new RssModel();
        $this->convertor = new Convertor_Rss();
    }

    /**
     * 获取RSS列表
     *
     * @return Json
     */
    public function getRssListAction() {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 10));
        $param['id'] = intval($this->getParamList('id'));
        $param['typeid'] = intval($this->getParamList('typeid'));
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getRssList($param);
        $count = $this->model->getRssCount($param);
        $data = $this->convertor->getRssListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改RSS信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateRssByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['name_zh'] = $this->getParamList('name_zh');
            $param ['name_en'] = $this->getParamList('name_en');
            $param ['rss'] = $this->getParamList('rss');
            $param ['typeid'] = $this->getParamList('typeid');
            $param ['status'] = $this->getParamList('status');
            $data = $this->model->updateRssById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加RSS信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addRssAction() {
        $param = array();
        $param['name_zh'] = trim($this->getParamList('name_zh'));
        $param['name_en'] = trim($this->getParamList('name_en'));
        $param['rss'] = trim($this->getParamList('rss'));
        $param['typeid'] = intval($this->getParamList('typeid'));
        $param['status'] = intval($this->getParamList('status'));
        $data = $this->model->addRss($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 根据物业ID获取物业的RSS列表
     *
     * @return Json
     */
    public function getHotelRssListAction() {
        $hotelid = intval($this->getParamList('hotelid'));
        if (empty(hotelid)) {
            $this->throwException(2, '物业ID错误');
        }
        $hotelModel = new HotelListModel();
        $hotelInfo = $hotelModel->getHotelListDetail($hotelid);
        if (empty($hotelInfo)) {
            $this->throwException(3, '未找到对应物业');
        }
        $data = $this->convertor->getHotelRssListConvertor($hotelInfo['rss']);
        $this->echoSuccessData($data);
    }

    /**
     * 根据物业ID修改物业的RSS列表
     * @return Json
     */
    public function updateHotelRssListAction() {
        $hotelId = intval($this->getParamList('hotelid'));
        if ($hotelId) {
            $param = array();
            $hotelModel = new HotelListModel();
            $param ['rss'] = trim($this->getParamList('rss'));
            $data = $hotelModel->updateHotelListById($param, $hotelId);
            $data = $this->convertor->statusConvertor(array('id' => $data));
        } else {
            $this->throwException(1, '物业id不能为空');
        }
        $this->echoSuccessData($data);
    }

}
