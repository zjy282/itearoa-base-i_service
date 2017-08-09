<?php
/**
 * APP启动图数据层
 */
class Dao_AppImg extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询group_app_img列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppImgList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from group_app_img {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询group_app_img数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppImgCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from group_app_img {$paramSql['sql']}";
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
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
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
     * 根据id查询group_app_img详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getAppImgDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from group_app_img where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新group_app_img
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateAppImgById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('group_app_img', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加group_app_img数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addAppImg(array $info) {
        $this->db->insert('group_app_img', $info);
        return $this->db->lastInsertId();
    }

    /**
     * 获取最新可用的启动图
     *
     * @return array
     */
    public function getAvailableAppImg() {
        $sql = 'select * from group_app_img where status = 1 order by createtime desc';
        return $this->db->fetchAssoc($sql, array());
    }
}
