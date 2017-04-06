<?php

class OperateLogController extends \BaseController {

    private $model;

    private $convertor;

    public function init() {
        parent::init();
        $this->model = new OperateLogModel();
        $this->convertor = new Convertor_OperateLog();
    }

    /**
     * 获取OperateLog列表
     *
     * @return Json
     */
    public function getOperateLogListAction() {
        $param = array();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getOperateLogList($param);
        $data = $this->convertor->getOperateLogListConvertor($data);
        $this->echoJson($data);
    }

    /**
     * 根据id获取OperateLog详情
     *
     * @param
     *            int id 获取详情信息的id
     * @return Json
     */
    public function getOperateLogDetailAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $data = $this->model->getOperateLogDetail($id);
            $data = $this->convertor->getOperateLogDetail($data);
        } else {
            $this->throwException(1, '查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改OperateLog信息
     *
     * @param
     *            int id 获取详情信息的id
     * @param
     *            array param 需要更新的字段
     * @return Json
     */
    public function updateOperateLogByIdAction() {
        $id = intval($this->getParamList('id'));
        if ($id) {
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateOperateLogById($param, $id);
            $data = $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1, 'id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 添加OperateLog信息
     *
     * @param
     *            array param 需要新增的信息
     * @return Json
     */
    public function addOperateLogAction() {
        $param = array();
        $param['operatorid'] = intval($this->getParamList('operatorid'));
        $param['dataid'] = trim($this->getParamList('dataid'));
        $param['code'] = intval($this->getParamList('code'));
        $param['msg'] = trim($this->getParamList('msg'));
        $param['module'] = intval($this->getParamList('module'));
        $param['action'] = intval($this->getParamList('action'));
        $param['ip'] = trim($this->getParamList('ip'));
        $param['miscinfo'] = trim($this->getParamList('miscinfo'));
        $param['admintype'] = intval($this->getParamList('admintype'));
        $insertId = $this->model->addOperateLog($param);
        $this->echoSuccessData(array(
            'dataId' => $insertId
        ));
    }
}
