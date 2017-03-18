<?php

class Dao_ShortcutIcon extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_shortcut_icon列表
     * 
     * @param
     *            array 入参
     * @return array
     */
    public function getShortcutIconList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from hotel_shortcut_icon {$whereSql} order by sort desc";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_shortcut_icon详情
     * 
     * @param
     *            int id
     * @return array
     */
    public function getShortcutIconDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_shortcut_icon where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_shortcut_icon
     * 
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateShortcutIconById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_shortcut_icon', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_shortcut_icon数据
     * 
     * @param
     *            array
     * @return int id
     */
    public function addShortcutIcon(array $info) {
        $this->db->insert('hotel_shortcut_icon', $info);
        return $this->db->lastInsertId();
    }
}
