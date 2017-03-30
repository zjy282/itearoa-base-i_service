<?php

class FeedbackModel extends \BaseModel {

    private $dao;

    public function __construct(){
        parent::__construct();
        $this->dao = new Dao_Feedback();
    }
    
    /**
     * 获取Feedback列表信息
     * @param array param 查询条件
     * @return array
     */
    public function getFeedbackList(array $param){
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getFeedbackList($paramList);
    }

    /**
     * 根据id查询Feedback信息
     * @param int id 查询的主键
     * @return array
     */
    public function getFeedbackDetail($id){
        $result = array();
        if ($id){
            $result = $this->dao->getFeedbackDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Feedback信息
     * @param array param 需要更新的信息
     * @param int id 主键
     * @return array
     */
    public function updateFeedbackById($param,$id){
        $result = false;
        //自行添加要更新的字段,以下是age字段是样例
        if ($id){
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateFeedbackById($info,$id);
        }
        return $result;
    }

    /**
     * Feedback新增信息
     * @param array param 需要增加的信息
     * @return array
     */
    public function addFeedback($param){
        //自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addFeedback($info);
    }
}
