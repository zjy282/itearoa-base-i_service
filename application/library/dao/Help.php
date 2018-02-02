<?php
/**
 * 物业新闻管理数据层
 */
class Dao_Help extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询group_help列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getHelpList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $paramSql = $this->handlerHelpListParams($param);
        $sql = "select * from group_help {$paramSql['sql']} order by sort";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询group_help数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getHelpCount(array $param): int {
        $paramSql = $this->handlerHelpListParams($param);
        $sql = "select count(1) as count from group_help {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function handlerHelpListParams($param) {
        $whereSql = array();
        $whereCase = array();
        if (isset($param['groupid'])) {
            $whereSql[] = 'groupid = ?';
            $whereCase[] = $param['groupid'];
        }
        if (isset($param['typeid'])) {
            $whereSql[] = 'typeid = ?';
            $whereCase[] = $param['typeid'];
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
        	$whereSql[] = '(title_zh = ? or title_en = ?)';
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
     * 根据id查询group_help详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getHelpDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from group_help where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新group_help
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateHelpById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('group_help', $info, array( 'id' => $id) );
        }
        
        return $result;
    }

    /**
     * 单条增加group_help数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addHelp(array $info) {
        $this->db->insert('group_help', $info);
        return $this->db->lastInsertId();
    }
}
