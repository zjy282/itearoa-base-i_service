<?php

/**
 * 基础数据层
 */
class Dao_Base {

    /**
     * 数据库连接
     * @var Db_Connection|null
     */
    protected $db;

    public function __construct() {
        $this->db = Db_Connection::factory('iservice');
    }

    /**
     * 分页处理
     * @param $page
     * @param $limit
     * @return int
     */
    public function getStart($page, $limit) {
        $page = $page > 0 ? intval($page) : 1;
        return ($page - 1) * $limit;
    }

    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    /**
     * Commit
     */
    public function commit()
    {
        $this->db->commit();
    }

    /**
     * Rollback
     */
    public function rollback()
    {
        $this->db->rollback();
    }
}

?>
