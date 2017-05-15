<?php
/**
 * 城市信息控制器类
 *
 */
class CityController extends \BaseController {

	/**
	 *
	 * @var CityModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_City
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new CityModel ();
		$this->convertor = new Convertor_City ();
	}

	/**
	 * 获取城市列表
	 *
	 * @return Json
	 */
	public function getCityListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page' ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['id'] = intval ( $this->getParamList ( 'id' ) );
		$data = $this->model->getCityList ( $param );
		$count = $this->model->getCityCount ( $param );
		$data = $this->convertor->getCityListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取城市详情
	 * 
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getCityDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getCityDetail ( $id );
			$data = $this->convertor->getCityDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改城市信息
	 * 
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateCityByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['name'] = trim ( $this->getParamList ( 'name' ) );
			$data = $this->model->updateCityById ( $param, $id );
			$data = $this->convertor->commonConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 添加城市信息
	 * 
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addCityAction() {
		$param = array ();
		$param ['name'] = trim ( $this->getParamList ( 'name' ) );
		$data = $this->model->addCity ( $param );
		$data = $this->convertor->commonConvertor ( $data );
		$this->echoJson ( $data );
	}
}
