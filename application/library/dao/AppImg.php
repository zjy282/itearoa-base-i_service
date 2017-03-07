<?php

class Dao_AppImg extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询iservice_app_img列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getAppImgList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);
        $sql = "select * from iservice_app_img limit {$page},{$limit}";
        $result = $this->db->fetchAll($sql, array());
        return is_array($result) ? $result : array();
    }

    /**
     * 根据id查询iservice_app_img详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getAppImgDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from iservice_app_img where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新iservice_app_img
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
            $result = $this->db->update('iservice_app_img', $info, $id);
        }
        
        return $result;
    }

    /**
     * 单条增加iservice_app_img数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addAppImg(array $info) {
        $this->db->insert('iservice_app_img', $info);
        return $this->db->lastInsertId();
    }

    /**
     * 获取最新可用的启动图
     *
     * @return array
     */
    public function getAvailableAppImg() {
        $sql = 'select * from iservice_app_img where status = 1 order by createtime desc';
        return $this->db->fetchAssoc($sql, array());
    }
}
