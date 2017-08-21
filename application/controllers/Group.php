<?php

/**
 * 集团信息转换器类
 */
class GroupController extends \BaseController {

    /** @var  GroupModel */
    private $model;
    /** @var  Convertor_Group */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new GroupModel ();
        $this->convertor = new Convertor_Group ();
    }

    /**
     * 获取集团信息列表
     *
     * @return Json
     */
    public function getGroupListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $data = $this->model->getGroupList($param);
        $count = $this->model->getGroupCount($param);
        $data = $this->convertor->getGroupListConvertor($data, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取集团信息详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getGroupDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getGroupDetail($id);
            if (Enum_System::notAdminPackage($this->package)) {
                $data = $this->convertor->getGroupDetailConvertor($data);
            } else {
                $data = $this->convertor->getAdminGroupDetailConvertor($data);
            }
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改集团信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateGroupbyIdAction() {
        $paramList = $this->getParamList(false);
        $id = intval($paramList ['id']);
        if ($id) {
            $param = array();
            isset ($paramList ['name']) ? $param ['name'] = trim($paramList ['name']) : false;
            isset ($paramList ['enname']) ? $param ['enName'] = trim($paramList ['enname']) : false;
            isset ($paramList ['porturl']) ? $param ['portUrl'] = trim($paramList ['porturl']) : false;
            isset ($paramList ['about_zh']) ? $param ['about_zh'] = trim($paramList ['about_zh']) : false;
            isset ($paramList ['about_en']) ? $param ['about_en'] = trim($paramList ['about_en']) : false;
            $data = $this->model->updateGroupById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加集团信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addGroupAction() {
        $param = array();
        $param ['name'] = trim($this->getParamList('name'));
        $param ['enName'] = trim($this->getParamList('enname'));
        $param ['portUrl'] = trim($this->getParamList('porturl'));
        $data = $this->model->addGroup($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
