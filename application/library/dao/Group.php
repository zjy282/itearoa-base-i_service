<?php
/**
 * 集团信息DAO类
 */
class Dao_Group extends Dao_Base {

    public function __construct(){
        parent::__construct();
    }

    public function getGroupList(array $param):array{
        $limit = $param['limit']?intval($param['limit']):0;
        $page = $this->getStart($param['page'],$limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from group_list {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result)?$result:array();
    }

    /**
     * 查询group_list数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getGroupCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from group_list {$paramSql['sql']}";
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
        if ($param['id']) {
            if (is_array($param['id'])) {
                $whereSql[] = 'id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'id = ?';
                $whereCase[] = $param['id'];
            }
        }


        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    public function getGroupDetail (int $id):array{
        $result = array ();
        
        if ($id){
            $sql = "select * from group_list where id=?";
            $result = $this->db->fetchAssoc($sql,array($id));
        }

        return $result;
    }

    public function updateGroupById(array $info,int $id){
        $result = false;
        if ($id){
            $result = $this->db->update('group_list',$info,array('id' => $id));
        }

        return $result;
    }

    public function addGroup(array $info){
        $this->db->insert('group_list', $info);
        return $this->db->lastInsertId();
    }
}

