<?php
/**
 * 物业调查问卷数据层
 */
class Dao_Feedback extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_feedback列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFeedbackList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerFeedbackListParams($param);
        $sql = "select * from hotel_feedback {$paramSql['sql']} order by sort";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_feedback数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFeedbackCount(array $param): int {
        $paramSql = $this->handlerFeedbackListParams($param);
        $sql = "select count(1) as count from hotel_feedback {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerFeedbackListParams($param) {
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
        if (isset($param['listid'])) {
            $whereSql[] = 'listid = ?';
            $whereCase[] = $param['listid'];
        }
        if (isset($param['question'])) {
            $whereSql[] = 'question = ?';
            $whereCase[] = $param['question'];
        }
        if (isset($param['type'])) {
            $whereSql[] = 'type = ?';
            $whereCase[] = $param['type'];
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
     * 根据id查询hotel_feedback详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getFeedbackDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_feedback where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_feedback
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateFeedbackById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_feedback', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_feedback数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addFeedback(array $info) {
        $this->db->insert('hotel_feedback', $info);
        return $this->db->lastInsertId();
    }
}
