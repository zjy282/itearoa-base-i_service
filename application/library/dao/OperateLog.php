<?php
/**
 * 操作日志管理数据层
 */
class Dao_OperateLog extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_operate_log列表
     * @param array 入参
     * @return array
     */
    public function getOperateLogList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from iservice_operate_log {$paramSql['sql']} order by addtime desc";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询iservice_operate_log数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getOperateLogCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from iservice_operate_log {$paramSql['sql']}";
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
        if ($param['operatorid']) {
            $whereSql[] = 'operatorid = ?';
            $whereCase[] = $param['operatorid'];
        }
        if ($param['module']) {
            $whereSql[] = 'module = ?';
            $whereCase[] = $param['module'];
        }
        if (isset($param['code'])) {
            if ($param['code'] > 0) {
                $whereSql[] = 'code <> 0';
            } else {
                $whereSql[] = 'code = 0';
            }
        }
        if ($param['admintype']) {
            $whereSql[] = 'admintype = ?';
            $whereCase[] = $param['admintype'];
        }
        if ($param['admintypeid']) {
            $whereSql[] = 'admintypeid = ?';
            $whereCase[] = $param['admintypeid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询iservice_operate_log详情
     * @param int id
     * @return array
     */
    public function getOperateLogDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from iservice_operate_log where id=?";
            $result = $this->db->fetchAssoc($sql, array($id));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_operate_log
     * @param array 需要更新的数据
     * @param int id
     * @return array
     */
    public function updateOperateLogById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('iservice_operate_log', $info, $id);
        }

        return $result;
    }

    /**
     * 单条增加iservice_operate_log数据
     * @param array
     * @return int id
     */
    public function addOperateLog(array $info) {
        $this->db->insert('iservice_operate_log', $info);
        return $this->db->lastInsertId();
    }
}
