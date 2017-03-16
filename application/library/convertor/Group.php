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
    public function getGroupListConvertor($list){
        $data = array ();

        foreach ($list as $key => $value){
            $data [$key]['id'] = $value['id'];
            $data [$key]['name'] = $value['name'];
            $data [$key]['enName'] = $value['enname'];
            $data [$key]['portUrl'] = $value['port_url'];
        }

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
