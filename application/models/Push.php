<?php

/**
 * Class PushModel
 * 推送Model
 */
class PushModel extends \BaseModel {

    const MESSAGE_NOT_RECEIVED = "推送消息未送达";

    const APP_YSG_GROUP_ID = 1;
    const APP_SHANSHUI_GROUP_ID = 2;

    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Push();
    }

    /**
     * 获取Push列表信息
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPushList(array $param) {
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['type'] ? $paramList['type'] = $param['type'] : false;
        $param['dataid'] ? $paramList['dataid'] = $param['dataid'] : false;
        $param['content_type'] ? $paramList['content_type'] = $param['content_type'] : false;
        isset($param['result']) ? $paramList['result'] = intval($param['result']) : false;
        isset($param['platform']) ? $paramList['platform'] = intval($param['platform']) : false;
        $paramList['limit'] = $param['limit'];
        $paramList['page'] = $param['page'];
        return $this->dao->getPushList($paramList);
    }

    /**
     * 获取Push数量
     *
     * @param
     *            array param 查询条件
     * @return array
     */
    public function getPushCount(array $param) {
        $paramList = array();
        $param['id'] ? $paramList['id'] = $param['id'] : false;
        $param['type'] ? $paramList['type'] = $param['type'] : false;
        $param['dataid'] ? $paramList['dataid'] = $param['dataid'] : false;
        $param['content_type'] ? $paramList['content_type'] = $param['content_type'] : false;
        isset($param['result']) ? $paramList['result'] = intval($param['result']) : false;
        isset($param['platform']) ? $paramList['platform'] = intval($param['platform']) : false;
        return $this->dao->getPushCount($paramList);
    }

    /**
     * 根据id查询Push信息
     *
     * @param
     *            int id 查询的主键
     * @return array
     */
    public function getPushDetail($id) {
        $result = array();
        if ($id) {
            $result = $this->dao->getPushDetail($id);
        }
        return $result;
    }

    /**
     * 根据id更新Push信息
     *
     * @param
     *            array param 需要更新的信息
     * @param
     *            int id 主键
     * @return array
     */
    public function updatePushById($param, $id) {
        $result = false;
        // 自行添加要更新的字段,以下是age字段是样例
        if ($id) {
            $info['age'] = intval($param['age']);
            $result = $this->dao->updatePushById($info, $id);
        }
        return $result;
    }

    /**
     * Push新增信息
     *
     * @param
     *            array param 需要增加的信息
     * @return array
     */
    public function addPushOne($param, $platform = self::APP_YSG_GROUP_ID) {
        // 判断参数错误
        $info['type'] = intval($param['type']);
        if (empty($info['type'])) {
            $this->throwException('推送类型错误', 3);
        }
        $info['dataid'] = intval($param['dataid']);
        $info['platform'] = $param['platform'];
        $info['cn_title'] = $param['cn_title'];
        $info['cn_value'] = $param['cn_value'];
        $info['en_title'] = $param['en_title'];
        $info['en_value'] = $param['en_value'];
        if (empty($info['cn_value']) && empty($info['en_value'])) {
            $this->throwException('推送内容错误', 4);
        }

        if ($param['contentType'] && $param['contentValue']) {
            $info['contentType'] = $param['contentType'];
            $info['contentValue'] = $param['contentValue'];
        } elseif ($param['url']) {
            $info['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_URL;
            $info['contentValue'] = $param['url'];
        }
        if (empty($info['contentType']) || empty($info['contentValue'])) {
            $this->throwException('推送主体错误', 5);
        }

        $pushParams = array();
        $pushParams['contentType'] = $info['contentType'];
        $pushParams['contentValue'] = $info['contentValue'];
        switch ($param['type']) {
            case Enum_Push::PUSH_TYPE_ALL : //全量推送
                $pushParams['phoneType'] = $info['platform'];
                $pushParams['type'] = Enum_Push::PUSH_TYPE_ALL;
                $pushParams['cnTitle'] = $info['cn_title'];
                $pushParams['cnValue'] = $info['cn_value'];
                $pushParams['enTitle'] = $info['en_title'];
                $pushParams['enValue'] = $info['en_value'];
                break;
            case Enum_Push::PUSH_TYPE_USER ://按照用户推送
                if (empty($info['dataid'])) {
                    $this->throwException('推送ID错误', 4);
                }
                $pushParams['type'] = Enum_Push::PUSH_TYPE_ALIAS;
                $userModel = new UserModel();
                $userInfo = $userModel->getUserDetail($info['dataid']);
                if (empty($userInfo['platform'])) {
                    break;
                }
                $info['platform'] = $pushParams['phoneType'] = $userInfo['platform'];
                $pushParams['dataid'] = $userInfo['id'];
                $pushParams['datatype'] = Enum_Push::PUSH_ALIAS_USER_PREFIX;
                if ($userInfo['language'] == 'zh') {
                    $pushParams['language'] = Enum_Push::PUSH_TAG_LANG_CN;
                    $pushParams['title'] = $info['cn_title'];
                    $pushParams['value'] = $info['cn_value'];
                } else {
                    $pushParams['language'] = Enum_Push::PUSH_TAG_LANG_EN;
                    $pushParams['title'] = $info['en_title'];
                    $pushParams['value'] = $info['en_value'];
                }
                break;
            case Enum_Push::PUSH_TYPE_STAFF ://按照员工推送
                if (empty($info['dataid'])) {
                    $this->throwException('推送ID错误', 4);
                }
                $pushParams['type'] = Enum_Push::PUSH_TYPE_ALIAS;
                $staffModel = new StaffModel();
                $staffInfo = $staffModel->getStaffDetail($info['dataid']);
                if (empty($staffInfo['platform'])) {
                    break;
                }
                $info['platform'] = $pushParams['phoneType'] = $staffInfo['platform'];
                $pushParams['dataid'] = $staffInfo['id'];
                $pushParams['datatype'] = Enum_Push::PUSH_ALIAS_STAFF_PREFIX;
                //todo ESTSSLFMP get staff language from hotel_staff
                $pushParams['language'] = Enum_Push::PUSH_TAG_LANG_CN;
                $pushParams['title'] = $info['cn_title'];
                $pushParams['value'] = $info['cn_value'];
                break;
            case Enum_Push::PUSH_TYPE_HOTEL ://物业全量推送
                if (empty($info['dataid'])) {
                    $this->throwException('推送ID错误', 4);
                }
                $pushParams['phoneType'] = $info['platform'];
                $pushParams['cnTitle'] = $info['cn_title'];
                $pushParams['cnValue'] = $info['cn_value'];
                $pushParams['enTitle'] = $info['en_title'];
                $pushParams['enValue'] = $info['en_value'];
                $pushParams['hotelId'] = $info['dataid'];
                $pushParams['type'] = Enum_Push::PUSH_TYPE_TAG;
                break;
            case Enum_Push::PUSH_TYPE_GROUP ://集团全量推送
                if (empty($info['dataid'])) {
                    $this->throwException('推送ID错误', 4);
                }
                $pushParams['phoneType'] = $info['platform'];
                $pushParams['cnTitle'] = $info['cn_title'];
                $pushParams['cnValue'] = $info['cn_value'];
                $pushParams['enTitle'] = $info['en_title'];
                $pushParams['enValue'] = $info['en_value'];
                $pushParams['groupId'] = $info['dataid'];
                $pushParams['type'] = Enum_Push::PUSH_TYPE_TAG;
                break;
        }

        //新政推送记录
        $pushResult = $this->_pushMsg($pushParams, $platform);
        $info['createtime'] = time();
        $info['result'] = $pushResult['code'];
        $info['request'] = $pushResult['body'];
        $info['httpcode'] = $pushResult['httpCode'];
        $info['response'] = $pushResult['result'];
        $info['content_type'] = $info['contentType'];
        $info['content_value'] = $info['contentValue'];
        unset($info['contentType'], $info['contentValue']);
        return $this->dao->addPush($info);
    }

    /**
     * Push message
     *
     * @param $param
     * @param int $platform specify which APP
     * @return array|bool
     */
    private function _pushMsg($param, $platform = self::APP_YSG_GROUP_ID)
    {
        //获取推送配置
        $config = Enum_Push::getConfig('umeng');
        if (is_null($config[$platform])) {
            $config = $config[self::APP_YSG_GROUP_ID];
        }
        $push = new Push_Push(
            array(
                'android' => $config['android']['appKey'],
                'ios' => $config['ios']['appKey'],
            ),
            array(
                'android' => $config['android']['secretKey'],
                'ios' => $config['ios']['secretKey'],
            )
        );

        $info = array();
        $pushResult = false;
        switch ($param['type']) {
            case Enum_Push::PUSH_TYPE_ALL ://全量推送
                $info['tag'] = Enum_Push::PUSH_TAG_LANG_CN;
                $info['title'] = $param['cnTitle'];
                $info['value'] = $param['cnValue'];
                $info['phoneType'] = $param['phoneType'];
                $info['contentType'] = $param['contentType'];
                $info['contentValue'] = $param['contentValue'];
                $pushResultZh = $push->pushAll($info); //推送中文标签全量
                $info['tag'] = Enum_Push::PUSH_TAG_LANG_EN;
                $info['title'] = $param['enTitle'];
                $info['value'] = $param['enValue'];
                $pushResultEn = $push->pushAll($info);//推送英文标签全量

                $pushResult = array(
                    'code' => ($pushResultZh['code'] || $pushResultEn['code']) ? 1 : 0,
                    'body' => json_encode(array(
                            Enum_Push::PUSH_TAG_LANG_CN => json_decode($pushResultZh['body'], true),
                            Enum_Push::PUSH_TAG_LANG_EN => json_decode($pushResultEn['body'], true),
                        )
                    ),
                    'httpCode' => json_encode(array(
                            Enum_Push::PUSH_TAG_LANG_CN => $pushResultZh['httpCode'],
                            Enum_Push::PUSH_TAG_LANG_EN => $pushResultEn['httpCode'],
                        )
                    ),
                    'result' => json_encode(array(
                            Enum_Push::PUSH_TAG_LANG_CN => json_decode($pushResultZh['result'], true),
                            Enum_Push::PUSH_TAG_LANG_EN => json_decode($pushResultEn['result'], true),
                        )
                    )
                );
                break;
            case Enum_Push::PUSH_TYPE_ALIAS ://按照别名推送
                $dataId = array_unique(array_filter(explode(",", $param['dataid'])));
                if (!count($dataId)) {
                    $this->throwException('推送数据ID错误', 2);
                }
                $info['alias'] = implode(',', $dataId);
                $info['alias_type'] = $param['datatype'];
                $info['title'] = $param['title'];
                $info['contentType'] = $param['contentType'];
                $info['contentValue'] = $param['contentValue'];
                $info['value'] = $param['value'];
                $info['phoneType'] = $param['phoneType'];
                $pushResultOne = $push->pushAlias($info);

                $pushResult = array(
                    'code' => $pushResultOne['code'],
                    'body' => json_encode(array(
                            $param['language'] => json_decode($pushResultOne['body'], true),
                        )
                    ),
                    'httpCode' => json_encode(array(
                            $param['language'] => $pushResultOne['httpCode'],
                        )
                    ),
                    'result' => json_encode(array(
                            $param['language'] => json_decode($pushResultOne['result'], true),
                        )
                    )
                );
                break;
            case Enum_Push::PUSH_TYPE_TAG : //按照tag推送
                $dataId = array_unique(array_filter(explode(",", $param['dataid'])));
                if (count($dataId) > 0) {
                    $info['alias'] = implode(',', $dataId);
                    $info['alias_type'] = 'customizedcast';
                }
                $param['hotelId'] ? $info['tag'][] = Enum_Push::PUSH_TAG_HOTEL_PREFIX . $param['hotelId'] : false;
                $param['groupId'] ? $info['tag'][] = Enum_Push::PUSH_TAG_GROUP_PREFIX . $param['groupId'] : false;
                $info['title'] = $param['cnTitle'];
                $info['value'] = $param['cnValue'];
                $info['contentType'] = $param['contentType'];
                $info['contentValue'] = $param['contentValue'];
                $info['phoneType'] = $param['phoneType'];
                $info['tag'][] = Enum_Push::PUSH_TAG_LANG_CN;//推送中文部分设备
                $pushResultZh = $push->pushTag($info);
                $info['title'] = $param['enTitle'];
                $info['value'] = $param['enValue'];
                array_pop($info['tag']);
                $info['tag'][] = Enum_Push::PUSH_TAG_LANG_EN;//推送英文部分设备
                $pushResultEn = $push->pushTag($info);

                $pushResult = array(
                    'code' => ($pushResultZh['code'] || $pushResultEn['code']) ? 1 : 0,
                    'body' => json_encode(array(
                            Enum_Push::PUSH_TAG_LANG_CN => json_decode($pushResultZh['body'], true),
                            Enum_Push::PUSH_TAG_LANG_EN => json_decode($pushResultEn['body'], true),
                        )
                    ),
                    'httpCode' => json_encode(array(
                            Enum_Push::PUSH_TAG_LANG_CN => $pushResultZh['httpCode'],
                            Enum_Push::PUSH_TAG_LANG_EN => $pushResultEn['httpCode'],
                        )
                    ),
                    'result' => json_encode(array(
                            Enum_Push::PUSH_TAG_LANG_CN => json_decode($pushResultZh['result'], true),
                            Enum_Push::PUSH_TAG_LANG_EN => json_decode($pushResultEn['result'], true),
                        )
                    )
                );
                break;
        }
        return $pushResult;
    }

    /**
     * GSM推送
     * @param $paramList
     * @return array
     */
    public function pushGsmMsg($paramList) {
        $pushParams = array();
        $pushParams['cn_title'] = $paramList['cn_title'];
        $pushParams['cn_value'] = $paramList['cn_value'];
        $pushParams['en_title'] = $paramList['en_title'];
        $pushParams['en_value'] = $paramList['en_value'];
        $urlCode = $paramList['url_code'];

        $dataIdList = explode(",", $paramList['dataid']);
        if (empty($dataIdList)) {
            $this->throwException('用户ID无效', 3);
        }

        $sendSuccessIdList = array();
        switch ($paramList['type']) {
            case 1://用户ID推送
                $hotelModel = new HotelListModel();
                //获取用户信息
                $userModel = new UserModel();
                $userInfoList = $userModel->getUserList(array('oid' => $dataIdList));
                //获取对应物业的propertyinterfid
                $hotelIdList = array_column($userInfoList, 'hotelid');
                $hotelInfoList = $hotelModel->getHotelListList(array('id' => $hotelIdList));
                $propertyinterfIdList = array_column($hotelInfoList, 'propertyinterfid', 'id');
                foreach ($userInfoList as $userOne) {
                    if ($userOne['platform']) {
                        $redirectParams = array(
                            'OrderID' => $urlCode,
                            'PropertyInterfID' => $propertyinterfIdList[$userOne['hotelid']],
                            'CustomerID' => $userOne['oid'],
                            'Room' => $userOne['room_no'],
                            'groupid' => $userOne ['groupid'],
                            'LastName' => $userOne['fullname']
                        );
                        $pushParams['type'] = Enum_Push::PUSH_TYPE_USER;
                        $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_URL;
                        $pushParams['contentValue'] = $userModel->getGsmRedirect($redirectParams);
                        $pushParams['dataid'] = $userOne['id'];
                        if ($this->addPushOne($pushParams)) {
                            $sendSuccessIdList[] = $userOne['oid'];
                        }
                    }
                }
                break;
            case 2://员工ID推送
                $staffModel = new StaffModel();
                //获取员工信息
                $staffInfoList = $staffModel->getStaffList(array('staffid' => $dataIdList));
                foreach ($staffInfoList as $staffOne) {
                    if ($staffOne['platform']) {
                        $redirectParams = array(
                            'OrderID' => $urlCode,
                            'StaffID' => $staffOne['staffid']
                        );
                        $pushParams['type'] = Enum_Push::PUSH_TYPE_STAFF;
                        $pushParams['contentType'] = Enum_Push::PUSH_CONTENT_TYPE_URL;
                        $pushParams['contentValue'] = $staffModel->getGsmRedirect($redirectParams);
                        $pushParams['dataid'] = $staffOne['id'];
                        if ($this->addPushOne($pushParams)) {
                            $sendSuccessIdList[] = $staffOne['staffid'];
                        }
                    }
                }
                break;

        }
        return $sendSuccessIdList;
    }
}
