<?php


class Dao_SignSports extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Update sign_sports by id
     */
    public function updateSignById(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('sign_sports', $info, array(
                'id' => $id
            ));
        }
        return $result;
    }

    /**
     * @param array $info
     * @return string
     */
    public function add(array $info)
    {
        $this->db->insert('sign_sports', $info);
        return $this->db->lastInsertId();
    }

    /**
     * @param array $param
     * @return array
     */
    public function getSignList(array $param): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->_handlerListParams($param);
        $sql = "select * from sign_sports {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * @param array $params
     * @return int
     */
    public function getSignCount(array $params): int
    {
        $paramSql = $this->_handlerListParams($params);
        $sql = "select count(1) as count from sign_sports {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * @param $param
     * @return array
     */
    private function _handlerListParams($param)
    {
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
        if (isset($param['start'])) {
            $whereSql[] = 'created_at >= ?';
            $whereCase[] = $param['start'];
        }
        if (isset($param['end'])) {
            $whereSql[] = 'created_at <= ?';
            $whereCase[] = $param['end'];
        }

        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }

        if (isset($param['type'])) {
            $whereSql[] = 'type = ?';
            $whereCase[] = $param['type'];
        }

        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }
}
