<?php

/**
 * 评论数据层
 */
class Dao_Comment extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_comment列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getCommentList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from iservice_comment {$paramSql['sql']} order by createtime desc";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询iservice_comment数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getCommentCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from iservice_comment {$paramSql['sql']}";
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
        if ($param['datatype']) {
            $whereSql[] = '`datatype` = ?';
            $whereCase[] = $param['datatype'];
        }
        if ($param['dataid']) {
            $whereSql[] = '`dataid` = ?';
            $whereCase[] = $param['dataid'];
        }
        if ($param['status']) {
            $whereSql[] = '`status` = ?';
            $whereCase[] = $param['status'];
        }
        if ($param['roomno']) {
            $whereSql[] = '`roomno` = ?';
            $whereCase[] = $param['roomno'];
        }
        if ($param['hotelid']) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if ($param['groupid']) {
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
     * 根据id查询iservice_comment详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getCommentDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from iservice_comment where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_comment
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateCommentById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('iservice_comment', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加iservice_comment数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addComment(array $info) {
        $this->db->insert('iservice_comment', $info);
        return $this->db->lastInsertId();
    }
}
