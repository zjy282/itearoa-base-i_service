<?php

/**
 * 物业全景管理数据层
 */
class Dao_Panoramic extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_panoramic列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPanoramicList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_panoramic {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_panoramic数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPanoramicCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_panoramic {$paramSql['sql']}";
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
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['title'])) {
            $whereSql[] = '(title_lang1 = ? or title_lang2 = ? or title_lang3 = ?)';
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
            $whereCase[] = $param['title'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_Panoramic详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getPanoramicDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_panoramic where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_panoramic
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updatePanoramicById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_panoramic', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_panoramic数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addPanoramic(array $info) {
        $this->db->insert('hotel_panoramic', $info);
        return $this->db->lastInsertId();
    }
}
