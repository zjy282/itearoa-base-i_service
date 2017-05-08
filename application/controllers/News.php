<?php
class NewsController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new NewsModel ();
		$this->convertor = new Convertor_News ();
	}

	/**
	 * 获取News列表
	 *
	 * @return Json
	 */
	public function getNewsListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['tagid'] = intval ( $this->getParamList ( 'tagid' ) );
		$this->getPageParam ( $param );
		$newsList = $this->model->getNewsList ( $param );
		$newsCount = $this->model->getNewsCount ( $param );
		$newsTagModel = new NewsTagModel ();
		$tagList = $newsTagModel->getNewsTagList ( $param );
		$this->package != Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getNewsListConvertor ( $newsList, $tagList, $newsCount, $param ) : $data = $this->convertor->getAdminNewsListConvertor ( $newsList, $tagList, $newsCount, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取News详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getNewsDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getNewsDetail ( $id );
			$this->package != Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getNewsDetailConvertor ( $data ) : $data = $this->convertor->getAdminNewsDetailConvertor ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 根据id修改News信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateNewsByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$param = array ();
			$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
			$param ['status'] = intval ( $this->getParamList ( 'status' ) );
			$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
			$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
			$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
			$param ['article_lang1'] = trim ( $this->getParamList ( 'article_lang1' ) );
			$param ['article_lang2'] = trim ( $this->getParamList ( 'article_lang2' ) );
			$param ['article_lang3'] = trim ( $this->getParamList ( 'article_lang3' ) );
			$param ['tagid'] = trim ( $this->getParamList ( 'tagid' ) );
			$param ['updatetime'] = time ();
			$data = $this->model->updateNewsById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoJson ( $data );
	}

	/**
	 * 添加News信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addNewsAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$param ['title_lang1'] = trim ( $this->getParamList ( 'title_lang1' ) );
		$param ['title_lang2'] = trim ( $this->getParamList ( 'title_lang2' ) );
		$param ['title_lang3'] = trim ( $this->getParamList ( 'title_lang3' ) );
		$param ['article_lang1'] = trim ( $this->getParamList ( 'article_lang1' ) );
		$param ['article_lang2'] = trim ( $this->getParamList ( 'article_lang2' ) );
		$param ['article_lang3'] = trim ( $this->getParamList ( 'article_lang3' ) );
		$param ['tagid'] = trim ( $this->getParamList ( 'tagid' ) );
		$param ['updatetime'] = time ();
		$data = $this->model->addNews ( $param );
		$data = $this->convertor->statusConvertor ( $data );
		$this->echoJson ( $data );
	}
}
