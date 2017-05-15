<?php

/**
 * Class NoticTagModel
 * 物业通知标签管理
 */
class NoticTagModel extends \BaseModel {

	private $dao;

	public function __construct() {
		parent::__construct ();
		$this->dao = new Dao_NoticTag ();
	}

	/**
	 * 获取NoticTag列表信息
	 *
	 * @param
	 *        	array param 查询条件
	 * @return array
	 */
	public function getNoticTagList(array $param) {
		isset ( $param ['hotelid'] ) ? $paramList ['hotelid'] = intval ( $param ['hotelid'] ) : false;
		return $this->dao->getNoticTagList ( $paramList );
	}

	/**
	 * 获取NoticTag数量
	 *
	 * @param
	 *        	array param 查询条件
	 * @return array
	 */
	public function getNoticTagCount(array $param) {
		$paramList = array ();
		$param ['hotelid'] ? $paramList ['hotelid'] = intval ( $param ['hotelid'] ) : false;
		return $this->dao->getNoticTagCount ( $paramList );
	}

	/**
	 * 根据id查询NoticTag信息
	 *
	 * @param
	 *        	int id 查询的主键
	 * @return array
	 */
	public function getNoticTagDetail($id) {
		$result = array ();
		if ($id) {
			$result = $this->dao->getNoticTagDetail ( $id );
		}
		return $result;
	}

	/**
	 * 根据id更新NoticTag信息
	 *
	 * @param
	 *        	array param 需要更新的信息
	 * @param
	 *        	int id 主键
	 * @return array
	 */
	public function updateNoticTagById($param, $id) {
		$result = false;
		if ($id) {
			$info ['title_lang1'] = $param ['title_lang1'];
			$info ['title_lang2'] = $param ['title_lang2'];
			$info ['title_lang3'] = $param ['title_lang3'];
			$info ['hotelid'] = $param ['hotelid'];
			$result = $this->dao->updateNoticTagById ( $info, $id );
		}
		return $result;
	}

	/**
	 * NoticTag新增信息
	 *
	 * @param
	 *        	array param 需要增加的信息
	 * @return array
	 */
	public function addNoticTag($param) {
		$info ['title_lang1'] = $param ['title_lang1'];
		$info ['title_lang2'] = $param ['title_lang2'];
		$info ['title_lang3'] = $param ['title_lang3'];
		$info ['hotelid'] = $param ['hotelid'];
		return $this->dao->addNoticTag ( $info );
	}
}
