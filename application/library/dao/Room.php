<?php

/**
 * 房间管理数据层
 */
class Dao_Room extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询hotel_room列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getRoomList(array $param): array {
        $limit = $param['limit'] ? intval($param['limit']) : 0;
        $page = $this->getStart($param['page'], $limit);

        $paramSql = $this->handlerListParams($param);
        $sql = "select hotel_room.* from hotel_room left join hotel_user as hotelUser on hotelUser.room_no = hotel_room.room {$paramSql['sql']} order by hotelUser.lastlogintime desc,hotel_room.room";
        if ($limit) {
            $sql .= " limit {$page},{$limit}";
        }
        $result = $this->db->fetchAll($sql, $paramSql['case']);
        return is_array($result) ? $result : array();
    }

    /**
     * 查询hotel_room数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getRoomCount(array $param): int {
        $paramSql = $this->handlerListParams($param);
        $sql = "select count(1) as count from hotel_room {$paramSql['sql']}";
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
                $whereSql[] = 'hotel_room.id in (' . implode(',', $param['id']) . ')';
            } else {
                $whereSql[] = 'hotel_room.id = ?';
                $whereCase[] = $param['id'];
            }
        }
        if (isset($param['hotelid'])) {
            $whereSql[] = 'hotel_room.hotelid = ?';
            $whereCase[] = $param['hotelid'];
        }
        if (isset($param['room'])) {
            $whereSql[] = 'hotel_room.room = ?';
            $whereCase[] = $param['room'];
        }
        if (isset($param['floor'])) {
            $whereSql[] = 'hotel_room.floor = ?';
            $whereCase[] = $param['floor'];
        }
        if (isset($param['typeid'])) {
            $whereSql[] = 'hotel_room.typeid = ?';
            $whereCase[] = $param['typeid'];
        }
        $whereSql = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
        return array(
            'sql' => $whereSql,
            'case' => $whereCase
        );
    }

    /**
     * 根据id查询hotel_room详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getRoomDetail(int $id): array {
        $result = array();

        if ($id) {
            $sql = "select * from hotel_room where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }

        return $result;
    }

    /**
     * 根据id更新hotel_room
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateRoomById(array $info, int $id) {
        $result = false;

        if ($id) {
            $result = $this->db->update('hotel_room', $info, array('id' => $id));
        }

        return $result;
    }

    /**
     * 单条增加hotel_room数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addRoom(array $info) {
        $this->db->insert('hotel_room', $info);
        return $this->db->lastInsertId();
    }
}
