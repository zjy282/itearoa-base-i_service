<?php

class LifeModel extends \BaseModel {

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Life();
    }

    /**
     * 获取Life列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getLifeList(array $param) {
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getLifeList($paramList);
    }

    /**
     * 获取Life数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getLifeCount(array $param) {
        $param['typeid'] ? $paramList['typeid'] = $param['typeid'] : false;
        isset($param['hotelid']) ? $paramList['hotelid'] = $param['hotelid'] : false;
        isset($param['status']) ? $paramList['status'] = $param['status'] : false;
        return $this->dao->getLifeCount($paramList);
    }

    /**
     * 根据id查询Life信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getLifeDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getLifeDetail($id);
        }
        return $result;
    }

	/**
	 * 根据id更新Life信息
	 *
	 * @param
	 *        	array param 需要更新的信息
	 * @param
	 *        	int id 主键
	 * @return array
	 */
	public function updateLifeById($param, $id) {
		$result = false;
		if ($id) {
			$info = array();
			isset($param ['hotelid']) ? $info ['hotelid'] = intval ( $this->getParamList ( 'hotelid' ) ) : false;
			isset($param ['name_lang1']) ? $info ['name_lang1'] = $this->getParamList ( 'name_lang1' )  : false;
			isset($param ['name_lang2']) ? $info ['name_lang2'] = $this->getParamList ( 'name_lang2' )  : false;
			isset($param ['name_lang3']) ? $info ['name_lang3'] = $this->getParamList ( 'name_lang3' )  : false;
			isset($param ['detail_lang1']) ? $info ['detail_lang1'] = $this->getParamList ( 'detail_lang1' )  : false;
			isset($param ['detail_lang2']) ? $info ['detail_lang2'] = $this->getParamList ( 'detail_lang2' )  : false;
			isset($param ['detail_lang3']) ? $info ['detail_lang3'] = $this->getParamList ( 'detail_lang3' )  : false;
			isset($param ['address_lang1']) ? $info ['address_lang1'] = $this->getParamList ( 'address_lang1' )  : false;
			isset($param ['address_lang2']) ? $info ['address_lang2'] = $this->getParamList ( 'address_lang2' )  : false;
			isset($param ['address_lang3']) ? $info ['address_lang3'] = $this->getParamList ( 'address_lang3' )  : false;
			isset($param ['introduct_lang1']) ? $info ['introduct_lang1'] = $this->getParamList ( 'introduct_lang1' )  : false;
			isset($param ['hotelid']) ? $info ['hotelid'] = $this->getParamList ( 'hotelid' )  : false;
			$param ['introduct_lang1'] = trim ( $this->getParamList ( 'introduct_lang1' ) );
			$param ['introduct_lang2'] = trim ( $this->getParamList ( 'introduct_lang2' ) );
			$param ['introduct_lang3'] = trim ( $this->getParamList ( 'introduct_lang3' ) );
			$param ['tel'] = trim ( $this->getParamList ( 'tel' ) );
			$param ['lat'] = trim ( $this->getParamList ( 'lat' ) );
			$param ['lng'] = trim ( $this->getParamList ( 'lng' ) );
			$param ['updatetime'] = time ();
			$param ['status'] = intval ( $this->getParamList ( 'status' ) );
			$result = $this->dao->updateLifeById ( $info, $id );
		}
		return $result;
	}

    /**
     * Life新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addLife($param) {
    	$info = $param;
        return $this->dao->addLife($info);
    }
}
