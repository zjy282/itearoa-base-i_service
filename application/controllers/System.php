<?php
/**
 * 系统级别服务控制器类
 *
 */
class SystemController extends \BaseController {

	public function init() {
		parent::init ();
	}

	/**
	 * 获取服务器时间
	 *
	 * @return json
	 */
	public function getTimeAction() {
		$this->echoSuccessData ( array ('time' => time () ) );
	}

	/**
	 * 获取系统支持的语言列表
	 *
	 * @return json
	 */
	public function getLanguageListAction() {
		$this->echoSuccessData ( array ('list' => Enum_Lang::getLangNameList () ) );
	}

	/**
	 * 上传文件到OSS
	 *
	 * @return json
	 */
	public function uploadToOssAction() {
		$param = array ();
		$param ['type'] = trim ( $this->getParamList ( 'type' ) );
		$param ['uploadfile'] = $_FILES ['uploadfile'];
		$param ['oldfilekey'] = trim ( $this->getParamList ( 'oldfilekey' ) );
		$ossModel = new OssModel ();
		$result = $ossModel->uploadToOss ( $param );
		$this->echoSuccessData ( $result );
	}

	/**
	 * 获取上传允许的文件类型
	 *
	 * @return json
	 */
	public function getAllowUploadFileTypeAction() {
		$param = array ();
		$type = trim ( $this->getParamList ( 'type' ) );
		$this->echoSuccessData ( array ('list' => Enum_Oss::allowExtension ( $type ) ) );
	}

	/**
	 * 获取设备列表
	 *
	 * @return json
	 */
	public function getPlatformListAction() {
		$this->echoSuccessData ( array ('list' => Enum_Platform::getPlatformNameList () ) );
	}
}
