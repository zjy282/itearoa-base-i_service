<?php

class ListController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ListModel();
        $this->convertor = new Convertor_List();
    }

    /**
     * 获取List列表
     * 
     * @return Json
     */
    public function getListListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getListList($param);
        $data = $this->convertor->getListListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取List详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getListDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getListDetail($id);
            $data = $this->convertor->getListDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改List信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateListByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateListById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加List信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addListAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addList($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
