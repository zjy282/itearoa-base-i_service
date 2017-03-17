<?php
class Convertor_Administrator extends Convertor_Base {
    public function __construct(){
        parent::__construct();
    }

    /**
     * 集团管理员列表数据转换器
     * @param array $list
     * @return array
     */
    public function getAdministratorListConvertor($list){
        $data = array ();

        foreach ($list as $key => $value){
            $data [$key]['id'] = $value['id'];
            $data [$key]['userName'] = $value['username'];
            $data [$key]['realName'] = $value['realname'];
            $data [$key]['remark'] = $value['remark'];
            $data [$key]['status'] = $value['status'];
            $data [$key]['lastLoginTime'] = $value['lastlogintime'];
            $data [$key]['lastLoginIp'] = $value['lastloginip'];
            $data [$key]['createTime'] = $value['createtime'];
            $data [$key]['createAdmin'] = $value['createadmin'];
            $data [$key]['groupId'] = $value['groupid'];
        }

        return $data;
    }
    
    /**
     * 集团管理员详情数据转换器
     * @param array $result
     * @return array
     */
    public function getAdministratorDetailConvertor ($result){
        $data = array ();

        if (is_array($result) && count($result) > 0){
            $data ['id'] = $result['id'];
            $data ['userName'] = $result['username'];
            $data ['realName'] = $result['realname'];
            $data ['remark'] = $result['remark'];
            $data ['status'] = $result['status'];
            $data ['lastLoginTime'] = $result['lastlogintime'];
            $data ['lastLoginIp'] = $result['lastloginip'];
            $data ['createTime'] = $result['createtime'];
            $data ['createAdmin'] = $result['createadmin'];
            $data ['groupId'] = $result['groupid'];
        }

        return $data;
    }
} 
