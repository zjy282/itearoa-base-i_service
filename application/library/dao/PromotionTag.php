<?php

class Dao_PromotionTag extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_promotion_tag列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getPromotionTagList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_promotion_tag {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_promotion_tag详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getPromotionTagDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_promotion_tag where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_promotion_tag
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updatePromotionTagById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_promotion_tag', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_promotion_tag数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addPromotionTag(array $info) {
        $this->db->insert('hotel_promotion_tag', $info);
        return $this->db->lastInsertId();
    }
}
