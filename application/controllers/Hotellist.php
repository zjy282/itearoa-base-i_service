<?php

/**
 * 物业列表控制器类
 *
 */
class HotelListController extends \BaseController {

    /**
     *
     * @var HotelListModel
     */
    private $model;

    /**
     *
     * @var Convertor_HotelList
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new HotelListModel ();
        $this->convertor = new Convertor_HotelList ();
    }

    /**
     * 获取物业列表
     *
     * @return Json
     */
    public function getHotelListListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page'));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['name'] = trim($this->getParamList('name'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['propertyinterfid'] = $this->getParamList('propertyinterfid');
        $param ['status'] = $this->getParamList('status');
        if (is_null($param ['status'])) {
            unset ($param ['status']);
        }
        $data = $this->model->getHotelListList($param);
        $count = $this->model->getHotelListCount($param);
        $data = $this->convertor->getHotelListListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取物业详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getHotelListDetailAction() {
        $id = intval($this->getParamList('hotelid'));
        if ($id) {
            $hotelInfo = $this->model->getHotelListDetail($id);
            empty ($hotelInfo) ? $this->throwException(2, '物业信息不错在') : false;
            $shareIconModel = new ShareIconModel ();
            $hotelShareIcon = $shareIconModel->getShareIconList(array('hotelid' => $id));
            $shortCutIconModel = new ShortcutIconModel ();
            $hotelShortCutIcon = $shortCutIconModel->getShortcutIconList(array('hotelid' => $id));
            //获取集团接口信息
            $groupModel = new GroupModel();
            $hotelInfo['portUrl'] = $groupModel->getGroupPortByGroupId($hotelInfo['groupid']);
            $data = $this->convertor->getHotelListDetailConvertor($hotelInfo, $hotelShareIcon, $hotelShortCutIcon);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改物业信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateHotelListByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['groupid'] = $this->getParamList('groupid');
            $param ['propertyinterfid'] = $this->getParamList('propertyinterfid');
            $param ['lng'] = $this->getParamList('lng');
            $param ['lat'] = $this->getParamList('lat');
            $param ['cityid'] = $this->getParamList('cityid');
            $param ['tel'] = $this->getParamList('tel');
            $param ['name_lang1'] = $this->getParamList('name_lang1');
            $param ['name_lang2'] = $this->getParamList('name_lang2');
            $param ['name_lang3'] = $this->getParamList('name_lang3');
            $param ['website'] = $this->getParamList('website');
            $param ['logo'] = $this->getParamList('logo');
            $param ['index_background'] = $this->getParamList('index_background');
            $param ['localpic'] = $this->getParamList('localpic');
            $param ['listpic'] = $this->getParamList('listpic');
            $param ['voice_lang1'] = $this->getParamList('voice_lang1');
            $param ['voice_lang2'] = $this->getParamList('voice_lang2');
            $param ['voice_lang3'] = $this->getParamList('voice_lang3');
            $param ['address_lang1'] = $this->getParamList('address_lang1');
            $param ['address_lang2'] = $this->getParamList('address_lang2');
            $param ['address_lang3'] = $this->getParamList('address_lang3');
            $param ['introduction_lang1'] = $this->getParamList('introduction_lang1');
            $param ['introduction_lang2'] = $this->getParamList('introduction_lang2');
            $param ['introduction_lang3'] = $this->getParamList('introduction_lang3');
            $param ['status'] = $this->getParamList('status');
            $param ['lang_list'] = $this->getParamList('lang_list');
            $param ['bookurl'] = $this->getParamList('bookurl');
            $param ['pdf'] = $this->getParamList('pdf');
            $param['flighturl'] = $this->getParamList('flighturl');
            $param['surveyurl'] = $this->getParamList('surveyurl');
            $param['robot_pic'] = $this->getParamList('robot_pic');
            $param['washing_machine'] = $this->getParamList('washing_machine');
            $param['invoice_id'] = $this->getParamList('invoice_id');
            $data = $this->model->updateHotelListById($param, $id);
            $data = $this->convertor->statusConvertor(array('id' => $data));
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加物业信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addHotelListAction() {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['propertyinterfid'] = $this->getParamList('propertyinterfid');
        $param ['lng'] = $this->getParamList('lng');
        $param ['lat'] = $this->getParamList('lat');
        $param ['localpic'] = $this->getParamList('localpic');
        $param ['cityid'] = intval($this->getParamList('cityid'));
        $param ['tel'] = $this->getParamList('tel');
        $param ['name_lang1'] = $this->getParamList('name_lang1');
        $param ['name_lang2'] = $this->getParamList('name_lang2');
        $param ['name_lang3'] = $this->getParamList('name_lang3');
        $param ['website'] = $this->getParamList('website');
        $param ['logo'] = $this->getParamList('logo');
        $param ['index_background'] = $this->getParamList('index_background');
        $param ['localpic'] = $this->getParamList('localpic');
        $param ['listpic'] = $this->getParamList('listpic');
        $param ['voice_lang1'] = $this->getParamList('voice_lang1');
        $param ['voice_lang2'] = $this->getParamList('voice_lang2');
        $param ['voice_lang3'] = $this->getParamList('voice_lang3');
        $param ['address_lang1'] = $this->getParamList('address_lang1');
        $param ['address_lang2'] = $this->getParamList('address_lang2');
        $param ['address_lang3'] = $this->getParamList('address_lang3');
        $param ['introduction_lang1'] = $this->getParamList('introduction_lang1');
        $param ['introduction_lang2'] = $this->getParamList('introduction_lang2');
        $param ['introduction_lang3'] = $this->getParamList('introduction_lang3');
        $param ['status'] = intval($this->getParamList('status'));
        $param ['lang_list'] = $this->getParamList('lang_list');
        $param ['bookurl'] = $this->getParamList('bookurl');
        $param ['invoice_id'] = $this->getParamList('invoice_id');
        $data = $this->model->addHotelList($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 获取当前可用的物业列表
     *
     * @param
     *            int groupid 集团id
     * @return Json
     */
    public function getEffectiveHotelListAction() {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['status'] = 1;
        $lng = $this->getParamList('lng');
        $lat = $this->getParamList('lat');
        if (empty ($param ['groupid'])) {
            $this->throwException(2, '集团ID不能为空');
        }
        $hotelList = $this->model->getHotelListList($param);
        if (!is_null($lng) || !is_null($lat)) {
            $lng = floatval($lng);
            $lat = floatval($lat);
            $this->model->sortByDistance($hotelList, $lng, $lat);
        }

        $hotelList = $this->convertor->getEffectiveHotelListConvertor($hotelList);
        $this->echoSuccessData($hotelList);
    }

    /**
     * 获取物业详情页
     *
     * @param
     *            int hotelid 酒店ID
     * @return Json
     */
    public function getHotelDetailAction() {
        $param = array();
        $param ['hotelid'] = intval($this->getParamList('hotelid'));
        $param ['status'] = 1;
        if (empty ($param ['hotelid'])) {
            $this->throwException(2, '物业信息不存在');
        }
        // 获取物业信息
        $hotelInfo = $this->model->getHotelListDetail($param ['hotelid']);
        empty ($hotelInfo) ? $this->throwException(2, '物业信息不错在') : false;
        // 获取物业图片信息
        $hotelPicModel = new HotelPicModel ();
        $picList = $hotelPicModel->getHotelPicList($param);
        // 获取物业房型信息
        $roomTypeModel = new RoomtypeModel ();
        $roomTypeList = $roomTypeModel->getRoomtypeList($param);
        // 获取物业设施信息
        $facilitiesModel = new FacilitiesModel ();
        $facilitiesList = $facilitiesModel->getFacilitiesList($param);
        // 获取物业楼层信息
        $hotelFloorModel = new FloorModel ();
        $floorList = $hotelFloorModel->getFloorList($param);
        // 获取物业交通信息
        $trafficModel = new TrafficModel ();
        $trafficList = $trafficModel->getTrafficList($param);
        // 获取物业全景信息
        $panoramicModel = new PanoramicModel ();
        $panoramicList = $panoramicModel->getPanoramicList($param);

        $result = $this->convertor->hotelDetailConvertor(array('hotelInfo' => $hotelInfo, 'picList' => $picList, 'roomTypeList' => $roomTypeList, 'facilitiesList' => $facilitiesList, 'floorList' => $floorList, 'trafficList' => $trafficList, 'panoramicList' => $panoramicList));
        $this->echoSuccessData($result);
    }
}
