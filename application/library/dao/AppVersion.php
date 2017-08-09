<?php

/**
 * APP版本管理数据层
 */
class Dao_AppVersion extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询group_app_version列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppVersionList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from group_app_version {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询group_app_version数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppVersionCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from group_app_version {$paramSql['sql']}";
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
        if (isset($param['platform'])) {
            $whereSql[] = 'platform = ?';
            $whereCase[] = $param['platform'];
        }
        if (isset($param['forced'])) {
            $whereSql[] = 'forced = ?';
            $whereCase[] = $param['forced'];
        }
        if (isset($param['latest'])) {
            $whereSql[] = 'latest = ?';
            $whereCase[] = $param['latest'];
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
     * 根据id查询group_app_version详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getAppVersionDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from group_app_version where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新group_app_version
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateAppVersionById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('group_app_version', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加group_app_version数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addAppVersion(array $info) {
        $this->db->insert('group_app_version', $info);
        return $this->db->lastInsertId();
    }

    /**
     * 根据设备获取APP最新的版本信息
     *
     * @param int $platform
     *            设备类型
     * @return array
     */
    public function getLatestAppVersionByPlatform(int $platform, $groupid) {
        $result = array();
        if ($platform) {
            $sql = "select * from group_app_version where platform = ? and latest = 1 and groupid = ?";
            $result = $this->db->fetchAssoc($sql, array(
                $platform,
                $groupid
            ));
        }
        return $result;
    }
}
