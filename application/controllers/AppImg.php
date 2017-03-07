<?php

class AppImgController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new AppImgModel();
        $this->convertor = new Convertor_AppImg();
    }

    /**
     * 获取AppImg列表
     * 
     * @return Json
     */
    public function getAppImgListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getAppImgList($param);
        $data = $this->convertor->getAppImgListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取AppImg详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getAppImgDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getAppImgDetail($id);
            $data = $this->convertor->getAppImgDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改AppImg信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateAppImgByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateAppImgById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加AppImg信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addAppImgAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addAppImg($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
