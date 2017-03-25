<?php
class Convertor_IserviceAdministrator extends Convertor_Base {
    
    public function __construct (){
        parent::__construct();
    }

    /**
     * iservice administrator列表数据转换器
     * @param array $list
     * @return array
     */
    public function getIserviceAdministratorListConvertor($list){
        $data = array ();

        foreach ($list as $key => $value){
            $data [$key]['id'] = $value['id'];
            $data [$key]['userName'] = $value['username'];
            $data [$key]['realName'] = $value['realname'];
            $data [$key]['status'] = $value['status'];
            $data [$key]['remark'] = $value['remark'];
            $data [$key]['lastLoginTime'] = $value['lastlogintime'];
            $data [$key]['lastLoginIp'] = $value['lastloginip'];
        }

        return $data;
    }

    /**
     * administrator 详情数据转换器
     * @param array $result
     * @return array
     */
    public function getIserviceAdministratorDetailConvertor ($result){
        $data = array ();

        if (is_array($result) && count($result) > 0){
            $data ['id'] = $result['id'];
            $data ['userName'] = $result['username'];
            $data ['realName'] = $result['realname'];
            $data ['password'] = $result['password'];
            $data ['status'] = $result['status'];
            $data ['remark'] = $result['remark'];
            $data ['lastLoginTime'] = $result['lastlogintime'];
            $data ['lastLoginIp'] = $result['lastloginip'];
            $data ['createTime'] = $result['createtime'];
            $data ['createAdmin'] = $result['createadmin'];
        }

        return $data;
    }
}
