<?php
class NewsModel extends \BaseModel {

	private $dao;

	public function __construct() {
		parent::__construct ();
		$this->dao = new Dao_News ();
	}

	/**
	 * 获取News列表信息
	 *
	 * @param
	 *        	array param 查询条件
	 * @return array
	 */
	public function getNewsList(array $param) {
		isset ( $param ['hotelid'] ) ? $paramList ['hotelid'] = intval ( $param ['hotelid'] ) : false;
		$param ['tagid'] ? $paramList ['tagid'] = intval ( $param ['tagid'] ) : false;
		isset ( $param ['status'] ) ? $paramList ['status'] = intval ( $param ['status'] ) : false;
		$paramList ['limit'] = $param ['limit'];
		$paramList ['page'] = $param ['page'];
		return $this->dao->getNewsList ( $paramList );
	}

	/**
	 * 获取News数量
	 *
	 * @param
	 *        	array param 查询条件
	 * @return array
	 */
	public function getNewsCount(array $param) {
		isset ( $param ['hotelid'] ) ? $paramList ['hotelid'] = intval ( $param ['hotelid'] ) : false;
		$param ['tagid'] ? $paramList ['tagid'] = intval ( $param ['tagid'] ) : false;
		isset ( $param ['status'] ) ? $paramList ['status'] = intval ( $param ['status'] ) : false;
		return $this->dao->getNewsCount ( $paramList );
	}

	/**
	 * 根据id查询News信息
	 *
	 * @param
	 *        	int id 查询的主键
	 * @return array
	 */
	public function getNewsDetail($id) {
		$result = array ();
		if ($id) {
			$result = $this->dao->getNewsDetail ( $id );
		}
		return $result;
	}

	/**
	 * 根据id更新News信息
	 *
	 * @param
	 *        	array param 需要更新的信息
	 * @param
	 *        	int id 主键
	 * @return array
	 */
	public function updateNewsById($param, $id) {
		$result = false;
		if ($id) {
			$info = $param;
			$result = $this->dao->updateNewsById ( $info, $id );
		}
		return $result;
	}

	/**
	 * News新增信息
	 *
	 * @param
	 *        	array param 需要增加的信息
	 * @return array
	 */
	public function addNews($param) {
		$info = $param;
		return $this->dao->addNews ( $info );
	}
}
