<?php
/**
 * 总后台管理员控制器类
 *
 */
class IserviceAdministratorController extends \BaseController {

	/**
	 *
	 * @var IserviceAdministratorModel
	 */
	private $model;

	/**
	 *
	 * @var Convertor_IserviceAdministrator
	 */
	private $convertor;

	public function init() {
		parent::init ();
		$this->model = new IserviceAdministratorModel ();
		$this->convertor = new Convertor_IserviceAdministrator ();
	}

	/**
	 * 获取总后台管理员列表
	 *
	 * @return Json
	 */
	public function getIserviceAdministratorListAction() {
		$param = array ();
		$param ['page'] = intval ( $this->getParamList ( 'page', 1 ) );
		$param ['limit'] = intval ( $this->getParamList ( 'limit', 5 ) );
		$param ['id'] = intval ( $this->getParamList ( 'id' ) );
		$param ['username'] = trim ( $this->getParamList ( 'username' ) );
		$param ['status'] = $this->getParamList ( 'status' );
		if (is_null ( $param ['status'] )) {
			unset ( $param ['status'] );
		}
		$data = $this->model->getIserviceAdministratorList ( $param );
		$count = $this->model->getIserviceAdministratorCount ( $param );
		$data = $this->convertor->getIserviceAdministratorListConvertor ( $data, $count, $param );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id获取总后台管理员详情
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @return Json
	 */
	public function getIserviceAdministratorDetailAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$data = $this->model->getIserviceAdministratorDetail ( $id );
			$data = $this->convertor->getIserviceAdministratorDetail ( $data );
		} else {
			$this->throwException ( 1, '查询条件错误，id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 根据id修改总后台管理员信息
	 *
	 * @param
	 *        	int id 获取详情信息的id
	 * @param
	 *        	array param 需要更新的字段
	 * @return Json
	 */
	public function updateIserviceAdministratorByIdAction() {
		$id = intval ( $this->getParamList ( 'id' ) );
		if ($id) {
			$paramList = $this->getParamList ();
			$param = array ();
			isset ( $paramList ['username'] ) ? $param ['userName'] = trim ( $paramList ['username'] ) : false;
			$paramList ['password'] ? $param ['password'] = md5 ( trim ( $paramList ['password'] ) ) : false;
			isset ( $paramList ['realname'] ) ? $param ['realName'] = trim ( $paramList ['realname'] ) : false;
			isset ( $paramList ['remark'] ) ? $param ['remark'] = trim ( $paramList ['remark'] ) : false;
			isset ( $paramList ['status'] ) ? $param ['status'] = intval ( $paramList ['status'] ) : false;
			$data = $this->model->updateIserviceAdministratorById ( $param, $id );
			$data = $this->convertor->statusConvertor ( $data );
		} else {
			$this->throwException ( 1, 'id不能为空' );
		}
		$this->echoSuccessData ( $data );
	}

	/**
	 * 添加总后台管理员信息
	 *
	 * @param
	 *        	array param 需要新增的信息
	 * @return Json
	 */
	public function addIserviceAdministratorAction() {
		$param ['userName'] = trim ( $this->getParamList ( 'username' ) );
		$param ['password'] = md5 ( trim ( $this->getParamList ( 'password' ) ) );
		$param ['realName'] = trim ( $this->getParamList ( 'realname' ) );
		$param ['remark'] = trim ( $this->getParamList ( 'remark' ) );
		$param ['status'] = intval ( $this->getParamList ( 'status' ) );
		$param ['createAdmin'] = intval ( $this->getParamList ( 'createadmin' ) );
		$param ['createTime'] = time ();
		$data = $this->model->addIserviceAdministrator ( $param );
		$data = $this->convertor->statusConvertor ( array ('id' => $data ) );
		$this->echoSuccessData ( $data );
	}

	/**
	 * 登陆控制器
	 * ---
	 *
	 * @param string $username
	 *        	用户名
	 * @param string $password
	 *        	密码
	 */
	public function loginAction() {
		$param ['username'] = trim ( $this->getParamList ( 'username' ) );
		$param ['password'] = trim ( $this->getParamList ( 'password' ) );
		$param ['ip'] = trim ( $this->getParamList ( 'ip' ) );
		$userInfo = $this->model->login ( $param );
		$userInfo = $this->convertor->getIserviceAdministratorDetailConvertor ( $userInfo );
		$this->echoSuccessData ( $userInfo );
	}

	/**
	 * 修改登录密码
	 *
	 * @param int $userid
	 *        	用户ID
	 * @param string $oldpass
	 *        	原密码
	 * @param string $newpass
	 *        	新密码
	 */
	public function changePassAction() {
		$param ['userid'] = intval ( $this->getParamList ( 'userid' ) );
		$param ['oldpass'] = trim ( $this->getParamList ( 'oldpass' ) );
		$param ['newpass'] = trim ( $this->getParamList ( 'newpass' ) );
		$userInfo = $this->model->changePass ( $param );
		$userInfo = $this->convertor->getIserviceAdministratorDetailConvertor ( $userInfo );
		$this->echoSuccessData ( $userInfo );
	}
}
