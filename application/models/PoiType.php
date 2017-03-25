<?php

class PoiTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_PoiType();
    }

    /**
     * 获取PoiType列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPoiTypeList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPoiTypeList($paramList);
    }

    /**
     * 根据id查询PoiType信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPoiTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPoiTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新PoiType信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePoiTypeById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updatePoiTypeById($info, $id);
        }
        return $result;
    }

    /**
     * PoiType新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPoiType($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addPoiType($info);
    }
}
