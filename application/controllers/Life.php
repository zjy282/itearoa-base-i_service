<?php

class LifeController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new LifeModel();
        $this->convertor = new Convertor_Life();
    }

    /**
     * 获取Life列表
     *
     * @return Json
     */
    public function getLifeListAction() {
        $param = array();
        $param['typeid'] = intval($this->getParamList('typeid'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $this->getPageParam($param);
        
        if (empty($param['hotelid'])) {
            $this->throwException(2, '入参错误');
        }
        
        $poiList = $this->model->getLifeList($param);
        $poiCount = $this->model->getLifeCount($param);
        $this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getLifeListConvertor($poiList, $poiCount, $param) : $data = $this->convertor->getAdminLifeListConvertor($poiList, $poiCount, $param);
        
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取Life详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getLifeDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getLifeDetail($id);
            $this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getLifeDetailConvertor($data) : $data = $this->convertor->getAdminLifeDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改Life信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateLifeByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['hotelid'] = trim($this->getParamList('hotelid'));
            $param['name_lang1'] = trim($this->getParamList('name_lang1'));
            $param['name_lang2'] = trim($this->getParamList('name_lang2'));
            $param['name_lang3'] = trim($this->getParamList('name_lang3'));
            $param['detail_lang1'] = trim($this->getParamList('detail_lang1'));
            $param['detail_lang2'] = trim($this->getParamList('detail_lang2'));
            $param['detail_lang3'] = trim($this->getParamList('detail_lang3'));
            $param['address_lang1'] = trim($this->getParamList('address_lang1'));
            $param['address_lang2'] = trim($this->getParamList('address_lang2'));
            $param['address_lang3'] = trim($this->getParamList('address_lang3'));
            $param['introduct_lang1'] = trim($this->getParamList('introduct_lang1'));
            $param['introduct_lang2'] = trim($this->getParamList('introduct_lang2'));
            $param['introduct_lang3'] = trim($this->getParamList('introduct_lang3'));
            $param['detail_lang1'] = trim($this->getParamList('detail_lang1'));
            $param['detail_lang2'] = trim($this->getParamList('detail_lang2'));
            $param['detail_lang3'] = trim($this->getParamList('detail_lang3'));
            $param['tel'] = trim($this->getParamList('tel'));
            $param['lat'] = trim($this->getParamList('lat'));
            $param['lng'] = trim($this->getParamList('lng'));
            $param['updatetime'] = time();
            $param['status'] = intval($this->getParamList('status'));
            $data = $this->model->updateLifeById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

	/**
	 * 添加Life信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addLifeAction() {
		$param = array ();
		$param ['hotelid'] = trim ( $this->getParamList ( 'hotelid' ) );
		$param ['name_lang1'] = trim ( $this->getParamList ( 'name_lang1' ) );
		$param ['name_lang2'] = trim ( $this->getParamList ( 'name_lang2' ) );
		$param ['name_lang3'] = trim ( $this->getParamList ( 'name_lang3' ) );
		$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
		$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
		$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
		$param ['address_lang1'] = trim ( $this->getParamList ( 'address_lang1' ) );
		$param ['address_lang2'] = trim ( $this->getParamList ( 'address_lang2' ) );
		$param ['address_lang3'] = trim ( $this->getParamList ( 'address_lang3' ) );
		$param ['introduct_lang1'] = trim ( $this->getParamList ( 'introduct_lang1' ) );
		$param ['introduct_lang2'] = trim ( $this->getParamList ( 'introduct_lang2' ) );
		$param ['introduct_lang3'] = trim ( $this->getParamList ( 'introduct_lang3' ) );
		$param ['detail_lang1'] = trim ( $this->getParamList ( 'detail_lang1' ) );
		$param ['detail_lang2'] = trim ( $this->getParamList ( 'detail_lang2' ) );
		$param ['detail_lang3'] = trim ( $this->getParamList ( 'detail_lang3' ) );
		$param ['tel'] = trim ( $this->getParamList ( 'tel' ) );
		$param ['lat'] = trim ( $this->getParamList ( 'lat' ) );
		$param ['lng'] = trim ( $this->getParamList ( 'lng' ) );
		$param ['updatetime'] = time ();
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$data = $this->model->addLife ( $param );
		$data = $this->convertor->commonConvertor ( $data );
		$this->echoSuccessData ( $data );
	}
}
