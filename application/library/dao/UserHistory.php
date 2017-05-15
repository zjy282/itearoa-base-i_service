<?php

/**
 * 用户入住历史管理数据层
 */
class Dao_UserHistory extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_user_history列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getUserHistoryList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $whereSql = array();
        $whereCase = array();
        if (isset($param['userid'])) {
            $whereSql[] = 'userid = ?';
            $whereCase[] = $param['userid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';

        $sql = "select * from hotel_user_history {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询hotel_UserHistory详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getUserHistoryDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_UserHistory where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_user_history
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateUserHistoryById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_user_history', $info, $id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_user_history数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addUserHistory(array $info) {
        $this->db->insert('hotel_user_history', $info);
        return $this->db->lastInsertId();
    }
}
