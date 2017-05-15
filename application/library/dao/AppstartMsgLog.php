<?php
/**
 * APP启动消息记录数据层
 */
class Dao_AppstartMsgLog extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_appstart_msg_log列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppstartMsgLogList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if ($param['msgid']) {
            if (is_array($param['msgid'])) {
                $whereSql[] = 'msgid in (' . implode(',', $param['msgid']) . ')';
            } else {
                $whereSql[] = 'msgid = ?';
                $whereCase[] = $param['msgid'];
            }
        }
        if ($param['platform']) {
            $whereSql[] = 'platform = ?';
            $whereCase[] = $param['platform'];
        }
        if ($param['identity']) {
            $whereSql[] = 'identity = ?';
            $whereCase[] = $param['identity'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from iservice_appstart_msg_log {$whereSql}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询iservice_appstart_msg_log详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getAppstartMsgLogDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from iservice_appstart_msg_log where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新iservice_appstart_msg_log
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateAppstartMsgLogById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('iservice_appstart_msg_log', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加iservice_appstart_msg_log数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addAppstartMsgLog(array $info) {
        $this->db->insert('iservice_appstart_msg_log', $info);
        return $this->db->lastInsertId();
    }
}
