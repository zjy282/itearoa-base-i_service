<?php
/**
 * 物业调查问卷结果数据层
 */
class Dao_FeedbackResult extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_feedback_result列表
     * @param array 入参
     * @return array
     */
    public function getFeedbackResultList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from hotel_feedback_result {$paramSql['sql']} order by createtime desc";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_feedback_resul数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getFeedbackResultCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_feedback_result {$paramSql['sql']}";
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
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_feedback_result详情
     * @param int id
     * @return array
     */
    public function getFeedbackResultDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_feedback_result where id=?";
            $result = $this->db->fetchAssoc($sql, array($id));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_feedback_result
     * @param array 需要更新的数据
     * @param int id
     * @return array
     */
    public function updateFeedbackResultById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_feedback_result', $info, $id);
        }

        return $result;
    }

    /**
     * 单条增加hotel_feedback_result数据
     * @param array
     * @return int id
     */
    public function addFeedbackResult(array $info) {
        $this->db->insert('hotel_feedback_result', $info);
        return $this->db->lastInsertId();
    }
}
