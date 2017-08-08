<?php

/**
 * 雅士阁生活类型管理数据层
 */
class Dao_LifeType extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function getListWhereSql($param) {
        if (isset($param['page']) && isset($param['limit'])) {
            $whereList['pageList']['limit'] = $param['limit'] ? intval($param['limit']) : 0;
            $whereList['pageList']['page'] = $this->getStart($param['page'], $whereList['pageList']['limit']);
        }
        $whereSql = array();
        $whereCase = array();
        if (isset($param['id'])) {
            if (is_array($param['id'])) {
                $whereSql[] = 'id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'id = ?';
                $whereCase[] = $param['id'];
            }
        }
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }

        $whereList['sql'] = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        $whereList['case'] = $whereCase;
        return $whereList;
    }

    /**
     * 查询hotel_life_type列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getLifeTypeList(array $param): array {
        $whereList = $this->getListWhereSql($param);
        $sql = "select * from hotel_life_type {$whereList['sql']}";
        if (isset($whereList['pageList'])) {
            $sql .= " limit {$whereList['pageList']['page']},{$whereList['pageList']['limit']}";
        }
        $result = $this->db->fetchAll($sql, $whereList['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_life_type数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getLifeTypeCount(array $param): int {
        $whereList = $this->getListWhereSql($param);
        $sql = "select count(1) as count from hotel_life_type {$whereList['sql']}";
        $result = $this->db->fetchAssoc($sql, $whereList['case']);
        return intval($result['count']);
    }

    /**
     * 根据id查询hotel_life_type详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getLifeTypeDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_life_type where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_life_type
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateLifeTypeById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_life_type', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_life_type数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addLifeType(array $info) {
        $this->db->insert('hotel_life_type', $info);
        return $this->db->lastInsertId();
    }
}
