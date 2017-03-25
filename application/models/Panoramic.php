<?php

class PanoramicModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Panoramic();
    }

    /**
     * 获取Panoramic列表信息
     * 
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPanoramicList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPanoramicList($paramList);
    }

    /**
     * 根据id查询Panoramic信息
     * 
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPanoramicDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPanoramicDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Panoramic信息
     * 
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePanoramicById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updatePanoramicById($info, $id);
        }
        return $result;
    }

    /**
     * Panoramic新增信息
     * 
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPanoramic($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addPanoramic($info);
    }
}
