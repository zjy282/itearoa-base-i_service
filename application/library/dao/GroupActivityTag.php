<?php
/**
 * 活动标签管理数据层
 */
class Dao_GroupActivityTag extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询group_activity_tag列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getActivityTagList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from group_activity_tag {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询group_activity_tag数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getActivityTagCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from group_activity_tag {$paramSql['sql']}";
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
        if (isset($param['groupid'])) {
            $whereSql[] = 'groupid = ?';
            $whereCase[] = $param['groupid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询group_activity_tag详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getActivityTagDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from group_activity_tag where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新group_activity_tag
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateActivityTagById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('group_activity_tag', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加group_activity_tag数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addActivityTag(array $info) {
        $this->db->insert('group_activity_tag', $info);
        return $this->db->lastInsertId();
    }
}
