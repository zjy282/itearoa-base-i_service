<?php

/**
 * 电话黄页分类管理数据层
 */
class Dao_TelType extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_tel_type列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getTelTypeList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_tel_type {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_tel_type数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getTelTypeCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_tel_type {$paramSql['sql']}";
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
        if (isset($param['title'])) {
            $whereSql[] = '(title_lang1 = ? or title_lang2 = ? or title_lang3 = ?)';
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
        }
        if (isset($param['islogin'])) {
            $whereSql[] = 'islogin = ?';
            $whereCase[] = $param['islogin'];
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
     * 根据id查询hotel_tel_type详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getTelTypeDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_tel_type where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_tel_type
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateTelTypeById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_tel_type', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_tel_type数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addTelType(array $info) {
        $this->db->insert('hotel_tel_type', $info);
        return $this->db->lastInsertId();
    }
}
