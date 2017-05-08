<?php
class NoticController extends \BaseController {

	private $model;

	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new NoticModel ();
		$this->convertor = new Convertor_Notic ();
	}

	/**
	 * 获取Notic列表
	 *
	 * @return Json
	 */
	public function getNoticListAction() {
		$param = array ();
		$param ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) );
		$param ['tagid'] = intval ( $this->getParamList ( 'tagid' ) );
		$this->getPageParam ( $param );
		$list = $this->model->getNoticList ( $param );
		$count = $this->model->getNoticCount ( $param );
		$tagModel = new NoticTagModel ();
		$tagList = $tagModel->getNoticTagList ( $param );
		$this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getNoticListConvertor ( $list, $tagList, $count, $param ) : $data = $this->convertor->getAdminNoticListConvertor ( $list, $tagList, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取Notic详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getNoticDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getNoticDetail ( $id );
			$this->package == Enum_System::ADMIN_PACKAGE ? $data = $this->convertor->getNoticDetailConvertor ( $data ) : $data = $this->convertor->getAdminNoticDetailConvertor ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改Notic信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateNoticByIdAction() {
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
			$data = $this->model->updateNoticById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加Notic信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addNoticAction() {
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
		$data = $this->model->addNotic ( $param );
		$data = $this->convertor->statusConvertor ( $data );
		$this->echoJson ( $data );
	}
}
