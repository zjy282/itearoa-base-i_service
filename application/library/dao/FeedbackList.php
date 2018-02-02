<?php
/**
 * 物业调查问卷数据层
 */
class Dao_FeedbackList extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_feedback_list列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFeedbackList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerFeedbackListParams($param);
        $sql = "select * from hotel_feedback_list {$paramSql['sql']} order by sort";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_feedback_list数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFeedbackCount(array $param): int {
        $paramSql = $this->handlerFeedbackListParams($param);
        $sql = "select count(1) as count from hotel_feedback_list {$paramSql['sql']}";
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
        if (isset($param['name'])) {
            $whereSql[] = 'name = ?';
            $whereCase[] = $param['name'];
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
     * 根据id查询hotel_feedback_list详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getFeedbackDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_feedback_list where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_feedback_list
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
            $result = $this->db->update('hotel_feedback_list', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_feedback_list数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addFeedback(array $info) {
        $this->db->insert('hotel_feedback_list', $info);
        return $this->db->lastInsertId();
    }
}
