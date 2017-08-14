<?php

/**
 * 集团帮助类别控制器类
 *
 */
class HelpTypeController extends \BaseController {

    /**
     * @var HelpTypeModel
     */
    private $model;

    /**
     * @var Convertor_HelpType
     */
    private $convertor;

    public function init() {
        parent::init();
        $this->model = new HelpTypeModel ();
        $this->convertor = new Convertor_HelpType ();
    }

    /**
     * 获取集团帮助类别列表
     *
     * @return Json
     */
    public function getTypeListAction() {
        $param = array();
        $param ['page'] = intval($this->getParamList('page', 1));
        $param ['limit'] = intval($this->getParamList('limit', 5));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $list = $this->model->getHelpTypeList($param);
        $count = $this->model->getHelpTypeCount($param);
        $data = $this->convertor->getTypeListConvertor($list, $count, $param);
        $this->echoSuccessData($data);
    }

    /**
     * 根据id获取集团帮助类别详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getTypeDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getHelpTypeDetail($id);
            $data = $this->convertor->getTypeDetailConvertor($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 根据id修改集团帮助类别信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateHelpTypeByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param ['title_zh'] = trim($this->getParamList('title_zh'));
            $param ['title_en'] = trim($this->getParamList('title_en'));
            $param ['sort'] = intval($this->getParamList('sort'));
            $data = $this->model->updateHelpTypeById($param, $id);
            $data = $this->convertor->statusConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoSuccessData($data);
    }

    /**
     * 添加集团帮助类别信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addHelpTypeAction() {
        $param = array();
        $param ['title_zh'] = trim($this->getParamList('title_zh'));
        $param ['title_en'] = trim($this->getParamList('title_en'));
        $param ['sort'] = intval($this->getParamList('sort'));
        $param ['groupid'] = intval($this->getParamList('groupid'));
        $data = $this->model->addHelpType($param);
        $data = $this->convertor->statusConvertor(array('id' => $data));
        $this->echoSuccessData($data);
    }
}
