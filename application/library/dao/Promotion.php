<?php

class Dao_Promotion extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_promotion列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPromotionList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $paramSql = $this->handlerPromotionListParams($param);
        $sql = "select * from hotel_promotion {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_promotion数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPromotionCount(array $param): int {
        $paramSql = $this->handlerPromotionListParams($param);
        $sql = "select count(1) as count from hotel_promotion {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    private function handlerPromotionListParams($param) {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['tagid'])) {
            $whereSql[] = 'tagid = ?';
            $whereCase[] = $param['tagid'];
        }
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        if (isset($param['id'])) {
        	$whereSql[] = 'id = ?';
        	$whereCase[] = $param['id'];
        }
        if (isset($param['title'])) {
        	$whereSql[] = '(title_lang1 = ? or title_lang2 = ? or title_lang2 = ?)';
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
     * 根据id查询hotel_promotion详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getPromotionDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_promotion where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_promotion
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updatePromotionById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_promotion', $info, array ( 'id' => $id));
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_promotion数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addPromotion(array $info) {
        $this->db->insert('hotel_promotion', $info);
        return $this->db->lastInsertId();
    }
}
