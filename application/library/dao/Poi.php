<?php

class Dao_Poi extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_poi列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPoiList(array $param): array {
		$limit = $param ['limit'] ? intval ( $param ['limit'] ) : 0;
		$page = $this->getStart ( $param ['page'], $limit );
		$paramSql = $this->handlerPoiListParams ( $param );
		$sql = "select * from hotel_poi {$paramSql['sql']}";
		if ($limit) {
			$sql .= " limit {$page},{$limit}";
		}
		$result = $this->db->fetchAll ( $sql, $paramSql ['case'] );
		return is_array ( $result ) ? $result : array ();
	}

    /**
     * 查询hotel_poi数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPoiCount(array $param): int {
        $paramSql = $this->handlerPoiListParams($param);
        $sql = "select count(1) as count from hotel_poi {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    private function handlerPoiListParams($param) {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['typeid'])) {
            $whereSql[] = 'typeid = ?';
            $whereCase[] = $param['typeid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['id'])) {
        	$whereSql[] = 'id = ?';
        	$whereCase[] = $param['id'];
        }
        if (isset($param['name'])) {
        	$whereSql[] = '(name_lang1 = ? or name_lang2 = ? or name_lang3 = ?)';
        	$whereCase[] = $param['name'];
        	$whereCase[] = $param['name'];
        	$whereCase[] = $param['name'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_poi详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getPoiDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_poi where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_poi
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updatePoiById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_poi', $info, array( 'id' => $id));
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_poi数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addPoi(array $info) {
        $this->db->insert('hotel_poi', $info);
        return $this->db->lastInsertId();
    }
}
