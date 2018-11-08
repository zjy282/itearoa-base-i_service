<?php

/**
 * Class Dao_RobotPosition
 */
class Dao_RobotPosition extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get robot position list
     *
     * @param array $param
     * @return array
     */
    public function getPositionList(array $param): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select * from robot_position {$paramSql['sql']} ORDER  BY position";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }


    /**
     * Get count of robot_position
     *
     * @param array $param
     * @return int
     */
    public function getRobotPositionCount(array $param): int
    {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from robot_position {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }


    /**
     * Get robot position detail by ID
     *
     * @param int $id
     * @return array
     */
    public function getRobotPositionDetail(int $id): array
    {
        $result = array();

        if ($id) {
            $sql = "select * from robot_position where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * Update robot position by ID
     *
     * @param array $info
     * @param int $id
     * @return bool|number|string
     */
    public function updatePosition(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('robot_position', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * Add new robot position
     *
     * @param array $info
     * @return int
     */
    public function addPosition(array $info): int
    {
        $this->db->insert('robot_position', $info);
        return intval($this->db->lastInsertId());
    }

    /**
     * Common param pre-process
     *
     * @param $param
     * @return array
     */
    private function handlerListParams($param)
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
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['type'])) {
            $whereSql[] = 'type = ?';
            $whereCase[] = $param['type'];
        }
        if (isset($param['position'])) {
            if (is_string($param['position'])) {
                $whereSql[] = 'position = ?';
                $whereCase[] = $param['position'];
            } elseif (is_array($param['position'])) {
                $whereSql[] = 'position in (?)';
                $whereCase[] = implode(',', $param['position']);
            }

        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }
}
