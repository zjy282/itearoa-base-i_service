<?php

/**
 * Class Dao_Sign
 */
class Dao_Sign extends Dao_Base
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get sign category list
     *
     * @param array $param
     * @return array
     */
    public function getSignCategoryList(array $param = array()): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->_handlerListParams($param);
        $sql = "select * from sign_categories {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    public function getSignItems(array $param = array()): array
    {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->_handlerListParams($param);
        $sql = "select * from sign_items {$paramSql['sql']}";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }


    /**
     * Get count of sign_categories
     *
     * @param array $param
     * @return int
     */
    public function getSignCategoriesCount(array $param): int
    {
        $paramSql = $this->_handlerListParams($param);
        $sql = "select count(1) as count from sign_categories {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    public function getSignItemsCount(array $param): int
    {
        $paramSql = $this->_handlerListParams($param);
        $sql = "select count(1) as count from sign_items {$paramSql['sql']}";
        $result = $this->db->fetchAssoc($sql, $paramSql['case']);
        return intval($result['count']);
    }

    /**
     * Update sign category by ID
     *
     * @param array $info
     * @param int $id
     * @return bool|number|string
     */
    public function updateCategory(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('sign_categories', $info, array('id' => $id));
        }

        return $result;
    }


    public function updateItem(array $info, int $id)
    {
        $result = false;

        if ($id) {
            $result = $this->db->update('sign_items', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * Add new sign category
     *
     * @param array $info
     * @return int
     */
    public function addCategory(array $info): int
    {
        $this->db->insert('sign_categories', $info);
        return intval($this->db->lastInsertId());
    }

    public function addItem(array $info): int
    {
        $this->db->insert('sign_items', $info);
        return intval($this->db->lastInsertId());
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
    public function addSign(array $info)
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
     * Common param pre-process
     *
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

        if (isset($param['hotelid'])) {
            if (is_array($param['hotelid'])) {
                $whereSql[] = 'hotelid in (' . implode(',', $param['hotelid']) . ')';
            } else {
                $whereSql[] = 'hotelid = ?';
                $whereCase[] = $param['hotelid'];
            }
        }

        if (isset($param['category_id'])) {
            if (is_array($param['category_id'])) {
                $whereSql[] = 'category_id in (' . implode(',', $param['category_id']) . ')';
            } else {
                $whereSql[] = 'category_id = ?';
                $whereCase[] = $param['category_id'];
            }
        }

        if (isset($param['type'])) {
            if (is_array($param['type'])) {
                $whereSql[] = 'type in (' . implode(',', $param['type']) . ')';
            } else {
                $whereSql[] = 'type = ?';
                $whereCase[] = $param['type'];
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
}
