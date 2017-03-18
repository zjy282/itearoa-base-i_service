<?php

class ShareIconModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShareIcon();
    }

    /**
     * 获取ShareIcon列表信息
     * 
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getShareIconList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getShareIconList($paramList);
    }

    /**
     * 根据id查询ShareIcon信息
     * 
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getShareIconDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getShareIconDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新ShareIcon信息
     * 
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateShareIconById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateShareIconById($info, $id);
        }
        return $result;
    }

    /**
     * ShareIcon新增信息
     * 
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addShareIcon($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addShareIcon($info);
    }
}
