<?php
class Dao_Base {
    protected $db;
    public function __construct() {
        $this->db = Db_Connection::factory('iservice');
    }

    public function getStart($page,$limit){
        $page = $page > 0 ?intval($page):1;
        return ($page - 1)*$limit;
    }
}
?>
