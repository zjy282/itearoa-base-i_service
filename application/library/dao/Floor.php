<?php

/**
 * 楼层管理数据层
 */
class Dao_Floor extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_floor列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFloorList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_floor {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_floor数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFloorCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_floor {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerListParams($param) {
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
        if (isset($param['floor'])) {
            $whereSql[] = 'floor = ?';
            $whereCase[] = $param['floor'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_floor详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getFloorDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_floor where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_floor
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateFloorById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_floor', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_floor数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addFloor(array $info) {
        $this->db->insert('hotel_floor', $info);
        return $this->db->lastInsertId();
    }
}
