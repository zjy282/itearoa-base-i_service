<?php

/**
 * 集团帮助控制器类
 *
 */
class HelpController extends \BaseController {

    /**
     * @var HelpModel
     */
    private $model;

    /**
     * @var Convertor_Help
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new HelpModel ();
        $this->convertor = new Convertor_Help ();
    }

    /**
     * 获取集团帮助列表
     *
     * @return Json
     */
    public function getHelpListAction() {
        $param = array();
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['typeid'] = intval($this->getParamList('typeid'));
        $param ['id'] = intval($this->getParamList('id'));
        $param ['status'] = $this->getParamList('status');
        $param ['title'] = $this->getParamList('title');
        $this->getPageParam($param);
        $HelpList = $this->model->getHelpList($param);
        $HelpCount = $this->model->getHelpCount($param);
        $data = $this->convertor->getAdminHelpListConvertor($HelpList, $HelpCount, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取集团帮助详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getHelpDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getHelpDetail($id);
            Enum_System::notAdminPackage($this->package) ? $data = $this->convertor->getHelpDetailConvertor($data) : $data = $this->convertor->getAdminHelpDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改集团帮助信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateHelpByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['title_zh'] = $this->getParamList('title_zh');
            $param ['title_en'] = $this->getParamList('title_en');
            $param ['sort'] = $this->getParamList('sort');
            $param ['help_zh'] = $this->getParamList('help_zh');
            $param ['help_en'] = $this->getParamList('help_en');
            $param ['status'] = $this->getParamList('status');
            $param ['groupid'] = $this->getParamList('groupid');
            $param ['typeid'] = $this->getParamList('typeid');
            $data = $this->model->updateHelpById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加集团帮助信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addHelpAction() {
        $param = array();
        $param ['title_zh'] = $this->getParamList('title_zh');
        $param ['title_en'] = $this->getParamList('title_en');
        $param ['sort'] = intval($this->getParamList('sort'));
        $param ['help_zh'] = $this->getParamList('help_zh');
        $param ['help_en'] = $this->getParamList('help_en');
        $param ['status'] = intval($this->getParamList('status'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $param ['typeid'] = intval($this->getParamList('typeid'));
        $data = $this->model->addHelp($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }

    /**
     * 获取集团帮助信息
     */
    public function getGroupHelpAction() {
        $param = array();
        $param['groupid'] = intval($this->getParamList('groupid'));
        if (empty($param['groupid'])) {
            $this->throwException(2, '集团ID不能为空');
        }
        $param['status'] = 1;
        $typeModel = new HelpTypeModel();
        $helpModel = new HelpModel();
        $typeList = $typeModel->getHelpTypeList($param);
        $helpList = $helpModel->getHelpList($param);
        $data = $this->convertor->getGroupHelp($typeList, $helpList);
        $this->echoSuccessData($data);
    }
}
