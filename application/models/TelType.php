<?php

class TelTypeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_TelType();
    }

    /**
     * 获取TelType列表信息
     * 
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getTelTypeList(array $param) {
        isset($param['hotelid']) ? $paramList['hotelid'] = intval($param['hotelid']) : false;
        isset($param['islogin']) ? $paramList['islogin'] = intval($param['islogin']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getTelTypeList($paramList);
    }

    /**
     * 根据id查询TelType信息
     * 
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getTelTypeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getTelTypeDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新TelType信息
     * 
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateTelTypeById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateTelTypeById($info, $id);
        }
        return $result;
    }

    /**
     * TelType新增信息
     * 
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addTelType($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addTelType($info);
    }
}
