<?php
/**
 * 物业新闻标签管理数据层
 */
class Dao_NewsTag extends Dao_Base {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 列表和数量获取筛选参数处理
     * @param $param
     * @return array
     */
    private function getListWhereSql($param){
    	if (isset($param['page']) && isset($param['limit'])){
    		$whereList['pageList']['limit'] = $param['limit'] ? intval($param['limit']) : 0;
    		$whereList['pageList']['page'] = $this->getStart($param['page'], $whereList['pageList']['limit']);
    	}
    	$whereSql = array();
    	$whereCase = array();
    	if (isset($param['hotelid'])) {
    		$whereSql[] = 'hotelid = ?';
    		$whereCase[] = $param['hotelid'];
    	}
    	$whereList['sql'] = $whereSql ? ' where ' . implode(' and ', $whereSql) : '';
    	$whereList['case'] = $whereCase;
    	return $whereList;
    }
    
    /**
     * 查询hotel_news_tag列表
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getNewsTagList(array $param): array {
        $whereList = $this->getListWhereSql($param);
        $sql = "select * from hotel_news_tag {$whereList['sql']}";
        if (isset($whereList['pageList'])) {
            $sql .= " limit {$whereList['pageList']['page']},{$whereList['pageList']['limit']}";
        }
        $result = $this->db->fetchAll($sql, $whereList['case']);
        return is_array($result) ? $result : array();
    }
    
    /**
     * 查询hotel_news_tag数量
     *
     * @param
     *            array 入参
     * @return array
     */
    public function getNewsTagCount(array $param): int {
    	$whereList = $this->getListWhereSql($param);
    	$sql = "select count(1) as count from hotel_news_tag {$whereList['sql']}";
    	$result = $this->db->fetchAssoc($sql, $whereList['case']);
    	return intval($result['count']);
    }

    /**
     * 根据id查询hotel_news_tag详情
     *
     * @param
     *            int id
     * @return array
     */
    public function getNewsTagDetail(int $id): array {
        $result = array();
        
        if ($id) {
            $sql = "select * from hotel_news_tag where id=?";
            $result = $this->db->fetchAssoc($sql, array(
                $id
            ));
        }
        
        return $result;
    }

    /**
     * 根据id更新hotel_news_tag
     *
     * @param
     *            array 需要更新的数据
     * @param
     *            int id
     * @return array
     */
    public function updateNewsTagById(array $info, int $id) {
        $result = false;
        
        if ($id) {
            $result = $this->db->update('hotel_news_tag', $info, array ( 'id' => $id) );
        }
        
        return $result;
    }

    /**
     * 单条增加hotel_news_tag数据
     *
     * @param
     *            array
     * @return int id
     */
    public function addNewsTag(array $info) {
        $this->db->insert('hotel_news_tag', $info);
        return $this->db->lastInsertId();
    }
}
