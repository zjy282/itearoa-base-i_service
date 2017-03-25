<?php

class Dao_NoticTag extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_notic_tag列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getNoticTagList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_notic_tag {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_notic_tag详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getNoticTagDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_notic_tag where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_notic_tag
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateNoticTagById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_notic_tag', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_notic_tag数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addNoticTag(array $info) {
        $this->db->insert('hotel_notic_tag', $info);
        return $this->db->lastInsertId();
    }
}
