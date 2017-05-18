<?php
/**
 * 酒店客房物品控制器类
 *
 */
class RoomResController extends \BaseController {

	/**
	 *
	 * @var RoomResModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_RoomRes
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new RoomResModel ();
		$this->convertor = new Convertor_RoomRes ();
	}

	/**
	 * 获取酒店客房物品列表
	 *
	 * @return Json
	 */
	public function getRoomResListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['id'] = intval ( $this->getParamList ( 'id' ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['icon'] = trim ( $this->getParamList ( 'icon' ) );
		$param ['name'] = trim ( $this->getParamList ( 'name' ) );
		$param ['status'] = $this->getParamList ( 'status' );
		if (is_null ( $param ['status'] )) {
			unset ( $param ['status'] );
		}
		$data = $this->model->getRoomResList ( $param );
		$count = $this->model->getRoomResCount ( $param );
		$data = $this->convertor->getRoomResListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取酒店客房物品详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getRoomResDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getRoomResDetail ( $id );
			$data = $this->convertor->getRoomResDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改酒店客房物品信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateRoomResByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['hotelid'] = $this->getParamList ( 'hotelid' );
			$param ['status'] = $this->getParamList ( 'status' );
			$param ['icon'] = $this->getParamList ( 'icon' );
		    $param ['pic'] = $this->getParamList ( 'pic' );
			$param ['pdf'] = $this->getParamList ( 'pdf' );
			$param ['name_lang1'] = $this->getParamList ( 'name_lang1' );
			$param ['name_lang2'] = $this->getParamList ( 'name_lang2' );
			$param ['name_lang3'] = $this->getParamList ( 'name_lang3' );
			$param ['introduct_lang1'] = $this->getParamList ( 'introduct_lang1' );
			$param ['introduct_lang2'] = $this->getParamList ( 'introduct_lang2' );
			$param ['introduct_lang3'] = $this->getParamList ( 'introduct_lang3' );
			$param ['detail_lang1'] = $this->getParamList ( 'detail_lang1' );
			$param ['detail_lang2'] = $this->getParamList ( 'detail_lang2' );
			$param ['detail_lang3'] = $this->getParamList ( 'detail_lang3' );
            $param ['sort'] = $this->getParamList('sort');
            $param ['video'] = $this->getParamList('video');
			$data = $this->model->updateRoomResById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加酒店客房物品信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addRoomResAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$param ['icon'] = trim ( $this->getParamList ( 'icon' ) );
		$param ['pic'] = trim ( $this->getParamList ( 'pic' ) );
		$param ['pdf'] = trim ( $this->getParamList ( 'pdf' ) );
		$param ['name_lang1'] = trim ( $this->getParamList ( 'name_lang1' ) );
		$param ['name_lang2'] = trim ( $this->getParamList ( 'name_lang2' ) );
		$param ['name_lang3'] = trim ( $this->getParamList ( 'name_lang3' ) );
		$param ['introduct_lang1'] = trim ( $this->getParamList ( 'introduct_lang1' ) );
		$param ['introduct_lang2'] = trim ( $this->getParamList ( 'introduct_lang2' ) );
		$param ['introduct_lang3'] = trim ( $this->getParamList ( 'introduct_lang3' ) );
        $param ['sort'] = intval($this->getParamList('sort'));
        $param ['video'] = trim($this->getParamList('video'));
		$data = $this->model->addRoomRes ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据房型ID和酒店ID获取设备列表
	 *
	 * @param
	 *        	int roomtypeid 房型ID
	 * @param
	 *        	int hotelid 酒店ID
	 * @return Json
	 */
	public function getHotelRoomTypeResListAction() {
		$param = array ();
		$param ['roomtypeid'] = intval ( $this->getParamList ( 'roomtypeid' ) );
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['status'] = 1;
		if (empty ( $param ['roomtypeid'] )) {
			$this->throwException ( 2, '房型信息不存在' );
		}
		if (empty ( $param ['hotelid'] )) {
			$this->throwException ( 3, '物业ID错误' );
		}
		// 获取房型信息
		$roomTypeModel = new RoomtypeModel ();
		$roomInfo = $roomTypeModel->getRoomtypeDetail ( $param ['roomtypeid'] );
		empty ( $roomInfo ) ? $this->throwException ( 2, '房型信息不存在' ) : false;
		$resIdList = Util_Tools::filterIdListArray ( explode ( ',', $roomInfo ['resid_list'] ) );
		$resList = $this->model->getRoomResList ( array ('id' => $resIdList,'status' => 1,'hotelid' => $param ['hotelid'] ) );
		$resList = $this->convertor->hotelRoomTypeResListConvertor ( $resList );
		$this->echoSuccessData ( $resList );
	}
}
