<?php
/**
 * 翻译控制器类
 *
 */
class TranslateController extends \BaseController {

	public function init() {
		parent::init ();
	}

	/**
	 * 获取翻译语言列表
	 */
	public function translateLanguageListAction() {
		$this->echoSuccessData ( array ('list' => Enum_Translate::translateList () ) );
	}

	/**
	 * 根据参数进行翻译
	 *
	 * @return json
	 */
	public function translateAction() {
		$param = array ();
		$param ['keyword'] = trim ( $this->getParamList ( 'keyword' ) );
		$param ['from'] = trim ( $this->getParamList ( 'from' ) );
		$param ['to'] = trim ( $this->getParamList ( 'to' ) );
		$translateModel = new TranslateModel ();
		$result = $translateModel->translate ( $param );
		$translateConvertor = new Convertor_Translate ();
		$result = $translateConvertor->translateResultConvertor ( $result );
		$this->echoSuccessData ( $result );
	}
}
