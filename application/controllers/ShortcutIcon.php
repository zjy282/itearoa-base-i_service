<?php

class ShortcutIconController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new ShortcutIconModel();
        $this->convertor = new Convertor_ShortcutIcon();
    }

    /**
     * 获取ShortcutIcon列表
     * 
     * @return Json
     */
    public function getShortcutIconListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getShortcutIconList($param);
        $data = $this->convertor->getShortcutIconListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取ShortcutIcon详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getShortcutIconDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getShortcutIconDetail($id);
            $data = $this->convertor->getShortcutIconDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改ShortcutIcon信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateShortcutIconByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateShortcutIconById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加ShortcutIcon信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addShortcutIconAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addShortcutIcon($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
