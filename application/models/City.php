<?php

/**
 * Class CityModel
 * 城市信息Model
 */
class CityModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_City();
    }

    /**
     * 获取City列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getCityList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getCityList($paramList);
    }

    /**
     * 获取City数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getCityCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = intval($param['id']) : false;
        return $this->dao->getCityCount($paramList);
    }

    /**
     * 根据id查询City信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getCityDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getCityDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新City信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updateCityById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updateCityById($info, $id);
        }
        return $result;
    }

    /**
     * City新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addCity($param) {
        // 自行添加要添加的字段,以下是age字段是样例
        $info['age'] = intval($param['age']);
        return $this->dao->addCity($info);
    }
}
