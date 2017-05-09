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
		$param ['id'] ? $paramList ['id'] = intval ( $param ['id'] ) : false;
		$param ['title'] ? $paramList ['title'] = $param ['title'] : false;
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
			$info = array () ;
			isset($param ['hotelid']) ? $info ['hotelid'] = $param ['hotelid'] : false;
			isset($param ['status']) ? $info ['status'] = $param ['status'] : false;
			isset($param ['title_lang1']) ? $info ['title_lang1'] = $param ['title_lang1'] : false;
			isset($param ['title_lang2']) ? $info ['title_lang2'] = $param ['title_lang2'] : false;
			isset($param ['title_lang3']) ? $info ['title_lang3'] = $param ['title_lang3'] : false;
			isset($param ['article_lang1']) ? $info ['article_lang1'] = $param ['article_lang1'] : false;
			isset($param ['article_lang2']) ? $info ['article_lang2'] = $param ['article_lang2'] : false;
			isset($param ['article_lang3']) ? $info ['article_lang3'] = $param ['article_lang3'] : false;
			isset($param ['tagid']) ? $info ['tagid'] = $param ['tagid'] : false;
			isset($param ['updatetime']) ? $info ['updatetime'] = $param ['updatetime'] : false;
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
