<?php

class Dao_AppstartPic extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_appstart_pic列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppstartPicList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        
        $whereSql = array();
        $whereCase = array();
        if (isset($param['status'])) {
            $whereSql[] = 'status = ?';
            $whereCase[] = $param['status'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        
        $sql = "select * from iservice_appstart_pic {$whereSql} limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, $whereCase);
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询iservice_appstart_pic详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getAppstartPicDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from iservice_appstart_pic where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新iservice_appstart_pic
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateAppstartPicById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('iservice_appstart_pic', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加iservice_appstart_pic数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addAppstartPic(array $info) {
        $this->db->insert('iservice_appstart_pic', $info);
        return $this->db->lastInsertId();
    }
}
