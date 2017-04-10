<?php
class Convertor_Group extends Convertor_Base {
    public function __construct(){
        parent::__construct();
    }

    /**
     * group列表数据转换器
     * @param array $list
     * @return array
     */
    public function getGroupListConvertor($list, $count, $param) {
        $data = array(
            'list' => array()
        );

        foreach ($list as $key => $value) {
            $oneTemp = array();
            $oneTemp['id'] = $value['id'];
            $oneTemp['name'] = $value['name'];
            $oneTemp['enname'] = $value['enname'];
            $oneTemp['port_url'] = $value['port_url'];
            $data['list'][] = $oneTemp;
        }
        $data['total'] = $count;
        $data['page'] = $param['page'];
        $data['limit'] = $param['limit'];
        $data['nextPage'] = Util_Tools::getNextPage($data['page'], $data['limit'], $data['total']);
        return $data;
    }

    /**
     * group 详情数据转换器
     * @param array $result
     * @return array
     */
    public function getGroupDetailConvertor ($result){
        $data = array ();

        if (is_array($result) && count($result) > 0){
            $data ['id'] = $result['id'];
            $data ['name'] = $result['name'];
            $data ['enName'] = $result['enname'];
            $data ['portUrl'] = $result['port_url'];
        }

        return $data;
    }
}
