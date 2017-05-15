<?php
/**
 * 总后台管理员管理数据层
 */
class Dao_IserviceAdministrator extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_administrator列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getIserviceAdministratorList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from iservice_administrator {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询iservice_administrator数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getIserviceAdministratorCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from iservice_administrator {$paramSql['sql']}";
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
        if (isset($param['username'])) {
            $whereSql[] = 'username = ?';
            $whereCase[] = $param['username'];
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
     * 根据username查询iservice_administrator详情
     *
     * @param
     *            string username
     * @return array
     */
    public function getIserviceAdministratorDetailByUsername(string $username): array {
        $result = array();

        if ($username) {
            $sql = "select * from iservice_administrator where username=?";
            $result = $this->db->fetchAssoc($sql, array(
                $username
            ));
            $result = $result ? $result : array();
        }

        return $result;
    }

    /**
     * 根据id查询iservice_administrator详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getIserviceAdministratorDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from iservice_administrator where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新iservice_administrator
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateIserviceAdministratorById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('iservice_administrator', $info, array(
                'id' => $id
            ));
        }

        return $result;
    }

    /**
     * 单条增加iservice_administrator数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addIserviceAdministrator(array $info) {
        $this->db->insert('iservice_administrator', $info);
        return $this->db->lastInsertId();
    }
}
