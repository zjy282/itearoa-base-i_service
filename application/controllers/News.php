<?php

class NewsController extends \BaseController {

    private $model;
    private $convertor;

    public function init() {
	    parent::init();
        $this->model = new NewsModel();
        $this->convertor = new Convertor_News();
    }

    /**
     * 获取News列表
     * 
     * @return Json
     */
    public function getNewsListAction () {
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->getNewsList($param);
        $data = $this->convertor->getNewsListConvertor($data);
        $this->echoJson($data);
    }


    /**
     * 根据id获取News详情
     * @param int id 获取详情信息的id
     * @return Json
     */
    public function getNewsDetailAction () {
        $id = intval($this->getParamList('id'));
        if ($id){
            $data = $this->model->getNewsDetail($id);
            $data = $this->convertor->getNewsDetail($data);
        } else {
            $this->throwException(1,'查询条件错误，id不能为空');
        }
        $this->echoJson($data);
    }

    /**
     * 根据id修改News信息
     * @param int id 获取详情信息的id
     * @param array param 需要更新的字段
     * @return Json
     */
    public function updateNewsByIdAction(){
        $id = intval($this->getParamList('id'));
        if ($id){
            $param = array();
            $param['name'] = trim($this->getParamList('name'));
            $data = $this->model->updateNewsById($param,$id); 
            $data = 
            $this->convertor->commonConvertor($data);
        } else {
            $this->throwException(1,'id不能为空');
        }
        $this->echoJson($data);
    }
    
    /**
     * 添加News信息
     * @param array param 需要新增的信息
     * @return Json
     */
    public function addNewsAction(){
        $param = array ();
        $param['name'] = trim($this->getParamList('name'));
        $data = $this->model->addNews($param);
        $data = $this->convertor->commonConvertor($data);
        $this->echoJson($data);
    }

}
