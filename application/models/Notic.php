<?php
class NoticModel extends \BaseModel {

	private $dao;

	public function __construct() {
		parent::__construct ();
		$this->dao = new Dao_Notic ();
	}

	/**
	 * 获取Notic列表信息
	 *
	 * @param
	 *        	array param 查询条件
	 * @return array
	 */
	public function getNoticList(array $param) {
		isset ( $param ['hotelid'] ) ? $paramList ['hotelid'] = intval ( $param ['hotelid'] ) : false;
		$param ['tagid'] ? $paramList ['tagid'] = intval ( $param ['tagid'] ) : false;
		isset ( $param ['status'] ) ? $paramList ['status'] = intval ( $param ['status'] ) : false;
		$paramList ['limit'] = $param ['limit'];
		$paramList ['page'] = $param ['page'];
		return $this->dao->getNoticList ( $paramList );
	}

	/**
	 * 获取Notic数量
	 *
	 * @param
	 *        	array param 查询条件
	 * @return array
	 */
	public function getNoticCount(array $param) {
		isset ( $param ['hotelid'] ) ? $paramList ['hotelid'] = intval ( $param ['hotelid'] ) : false;
		$param ['tagid'] ? $paramList ['tagid'] = intval ( $param ['tagid'] ) : false;
		isset ( $param ['status'] ) ? $paramList ['status'] = intval ( $param ['status'] ) : false;
		return $this->dao->getNoticCount ( $paramList );
	}

	/**
	 * 根据id查询Notic信息
	 *
	 * @param
	 *        	int id 查询的主键
	 * @return array
	 */
	public function getNoticDetail($id) {
		$result = array ();
		if ($id) {
			$result = $this->dao->getNoticDetail ( $id );
		}
		return $result;
	}

	/**
	 * 根据id更新Notic信息
	 *
	 * @param
	 *        	array param 需要更新的信息
	 * @param
	 *        	int id 主键
	 * @return array
	 */
	public function updateNoticById($param, $id) {
		$result = false;
		if ($id) {
			$info = $param;
			$result = $this->dao->updateNoticById ( $info, $id );
		}
		return $result;
	}

	/**
	 * Notic新增信息
	 *
	 * @param
	 *        	array param 需要增加的信息
	 * @return array
	 */
	public function addNotic($param) {
		$info = $param;
		return $this->dao->addNotic ( $info );
	}
}
