<?php

/**
 * 活动标签控制器类
 */
class ActivityTagController extends \BaseController {

    /**
     * @var ActivityTagModel
     */
    private $model;
    /**
     * @var Convertor_ActivityTag
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new ActivityTagModel();
        $this->convertor = new Convertor_ActivityTag();
    }

    /**
     * 获取ActivityTag列表
     *
     * @return Json
     */
    public function getActivityTagListAction() {
        $param = array();
        $param['page'] = intval($this->getParamList('page', 1));
        $param['limit'] = intval($this->getParamList('limit', 5));
        $param['id'] = intval($this->getParamList('id'));
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['status'] = $this->getParamList('status');
        if (is_null($param['status'])) {
            unset($param['status']);
        }
        $data = $this->model->getActivityTagList($param);
        $count = $this->model->getActivityTagCount($param);
        $data = $this->convertor->getActivityTagListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }


    /**
     * 根据id获取ActivityTag详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getActivityTagDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getActivityTagDetail($id);
            $data = $this->convertor->getActivityTagDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改ActivityTag信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateActivityTagByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['title_lang1'] = trim($this->getParamList('title_lang1'));
            $param['title_lang2'] = trim($this->getParamList('title_lang2'));
            $param['title_lang3'] = trim($this->getParamList('title_lang3'));
            $data = $this->model->updateActivityTagById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加ActivityTag信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addActivityTagAction() {
        $param = array();
        $param['hotelid'] = intval($this->getParamList('hotelid'));
        $param['title_lang1'] = trim($this->getParamList('title_lang1'));
        $param['title_lang2'] = trim($this->getParamList('title_lang2'));
        $param['title_lang3'] = trim($this->getParamList('title_lang3'));
        $data = $this->model->addActivityTag($param);
        $data = $this->convertor->statusConvertor(array(
            'id' => $data
        ));
        $this->echoSuccessData($data);
    }

    /**
     * 登陆控制器
     * ---
     *
     * @param string $username
     *            用户名
     * @param string $password
     *            密码
     */
    public function loginAction() {
        $param['username'] = trim($this->getParamList('username'));
        $param['password'] = trim($this->getParamList('password'));
        $param['ip'] = trim($this->getParamList('ip'));

        $userInfo = $this->model->login($param);
        $userInfo = $this->convertor->getActivityTagDetailConvertor($userInfo);

        $this->echoSuccessData($userInfo);
    }

    /**
     * 修改登录密码
     *
     * @param int $userid
     *            用户ID
     * @param string $oldpass
     *            原密码
     * @param string $newpass
     *            新密码
     */
    public function changePassAction() {
        $param['userid'] = intval($this->getParamList('userid'));
        $param['oldpass'] = trim($this->getParamList('oldpass'));
        $param['newpass'] = trim($this->getParamList('newpass'));

        $userInfo = $this->model->changePass($param);
        $userInfo = $this->convertor->getActivityTagDetailConvertor($userInfo);
        $this->echoSuccessData($userInfo);
    }

    /**
     * 获取物业后台管理员帐号权限列表
     */
    public function getHotelPermissionAction() {
        $this->echoSuccessData(array('list' => Enum_ActivityTag::getPermission()));
    }

}
