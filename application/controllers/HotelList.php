<?php

class HotelListController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new HotelListModel();
        $this->convertor = new Convertor_HotelList();
    }

    /**
     * 获取HotelList列表
     * 
     * @return Json
     */
    public function getHotelListListAction () {
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->getHotelListList($param);
        $data = $this->convertor->getHotelListListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取HotelList详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getHotelListDetailAction () {
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $data = $this->model->getHotelListDetail($id);
            $data = $this->convertor->getHotelListDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改HotelList信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateHotelListByIdAction(){
        $id = intval($this->getRequest()->getParam('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getRequest()->getParam('name'));
            $data = $this->model->updateHotelListById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加HotelList信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addHotelListAction(){
        $param = array ();
        $param['name'] = trim($this->getRequest()->getParam('name'));
        $data = $this->model->addHotelList($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
