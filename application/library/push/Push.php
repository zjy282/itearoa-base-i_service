<?php

class Push_Push {

    protected $androidKey = NULL;
    protected $iosKey = NULL;

    protected $androidMasterSecret = NULL;
    protected $iosMasterSecret = NULL;

    protected $timestamp = NULL;

    protected $validation_token = NULL;

    function __construct($key, $secret) {
        $this->androidKey = $key['android'];
        $this->iosKey = $key['ios'];
        $this->androidMasterSecret = $secret['android'];
        $this->iosMasterSecret = $secret['ios'];
        $this->timestamp = strval(time());
    }

    /**
     * 根据设备id进行推送
     * @param array $data
     *                   $data['title'] 推送title
     *                   $data['value'] 推送文本内容
     * @return bool
     */
    public function pushSignel($data) {
        if ($data['phoneType'] == Enum_Platform::PLATFORM_ID_ANDROID) {
            $unicast = new Push_Umeng_AndroidUnicast();
            $unicast->setPredefinedKeyValue("ticker", $data['title']);//通知栏提示文字
            $unicast->setPredefinedKeyValue("title", $data['title']);
            $unicast->setPredefinedKeyValue("text", $data['value']);
            $unicast->setAppMasterSecret($this->androidMasterSecret);
            $unicast->setPredefinedKeyValue("appkey", $this->androidKey);
            if ($data['contentType'] && $data['contentValue']) {
                $unicast->setPredefinedKeyValue("custom", json_encode(array('type' => $data['contentType'], 'value' => $data['contentValue'])));
                $unicast->setPredefinedKeyValue("after_open", "go_custom");
            } else {
                $unicast->setPredefinedKeyValue("after_open", "go_app");
            }
        } else {
            $unicast = new Push_Umeng_IOSUnicast();
            $unicast->setPredefinedKeyValue("alert", $data['title']);
            $unicast->setPredefinedKeyValue("badge", 0);
            $unicast->setPredefinedKeyValue("sound", "chime");
            $unicast->setCustomizedField("type", $data['contentType']);
            $unicast->setCustomizedField("value", $data['contentValue']);
            $unicast->setAppMasterSecret($this->iosMasterSecret);
            $unicast->setPredefinedKeyValue("appkey", $this->iosKey);
        }
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        $unicast->setPredefinedKeyValue("device_tokens", $data['dataid']);
        $unicast->setPredefinedKeyValue("production_mode", "true");
        return $unicast->send();
    }

    /**
     * 根据别名进行推送
     * @param array $data
     *                   $data['title'] 推送title
     *                   $data['value'] 推送文本内容
     * @return bool
     */
    public function pushAlias($data) {
        if ($data['phoneType'] == Enum_Platform::PLATFORM_ID_ANDROID) {
            $customizedcast = new Push_Umeng_AndroidCustomizedcast();
            $customizedcast->setPredefinedKeyValue("ticker", $data['title']);
            $customizedcast->setPredefinedKeyValue("title", $data['title']);
            $customizedcast->setPredefinedKeyValue("text", $data['value']);
            if ($data['contentType'] && $data['contentValue']) {
                $customizedcast->setPredefinedKeyValue("custom", json_encode(array('type' => $data['contentType'], 'value' => $data['contentValue'])));
                $customizedcast->setPredefinedKeyValue("after_open", "go_custom");
            } else {
                $customizedcast->setPredefinedKeyValue("after_open", "go_app");
            }
            $customizedcast->setAppMasterSecret($this->androidMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->androidKey);
        } else {
            $customizedcast = new Push_Umeng_IOSCustomizedcast();
            $alertArray = array(
                'title' => $data['title'],
                'body' => $data['value']
            );
            $customizedcast->setPredefinedKeyValue("alert", $alertArray);
            $customizedcast->setPredefinedKeyValue("badge", 0);
            $customizedcast->setPredefinedKeyValue("sound", "chime");
//            $customizedcast->setCustomizedField("type", $data['contentType']);
            if ($data['contentType'] == Enum_Push::PUSH_CONTENT_TYPE_URL) {
                $customizedcast->setCustomizedField("value", $data['contentValue']);
            }
            $customizedcast->setAppMasterSecret($this->iosMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->iosKey);
        }
        $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        $customizedcast->setPredefinedKeyValue("alias", $data['alias']);
        $customizedcast->setPredefinedKeyValue("alias_type", $data['alias_type']);
        $customizedcast->setPredefinedKeyValue("production_mode", "true");
        return $customizedcast->send();
    }

    /**
     * 根据别名进行推送
     * @param array $data
     *                   $data['title'] 推送title
     *                   $data['value'] 推送文本内容
     *                   $data['tag'] 推送group名称
     * @return bool
     */
    public function pushTag($data) {
        if ($data['tag']) {
            if (is_array($data['tag'])) {
                foreach ($data['tag'] as $tagValue) {
                    $tagList[] = array("tag" => $tagValue);
                }
            } else {
                $tagList[] = array("tag" => $data['tag']);
            }
        } else {
            return false;
        }
        $filter = array(
            "where" => array(
                "and" => $tagList
            )
        );
        if ($data['phoneType'] == Enum_Platform::PLATFORM_ID_ANDROID) {
            $customizedcast = new Push_Umeng_AndroidGroupcast();
            $customizedcast->setPredefinedKeyValue("ticker", $data['title']);
            $customizedcast->setPredefinedKeyValue("title", $data['title']);
            $customizedcast->setPredefinedKeyValue("text", $data['value']);
            if ($data['contentType'] && $data['contentValue']) {
                $customizedcast->setPredefinedKeyValue("custom", json_encode(array('type' => $data['contentType'], 'value' => $data['contentValue'])));
                $customizedcast->setPredefinedKeyValue("after_open", "go_custom");
            } else {
                $customizedcast->setPredefinedKeyValue("after_open", "go_app");
            }
            $customizedcast->setAppMasterSecret($this->androidMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->androidKey);
        } else {
            $customizedcast = new Push_Umeng_IOSGroupcast();
            $customizedcast->setPredefinedKeyValue("alert", $data['title']);
            $customizedcast->setPredefinedKeyValue("badge", 0);
            $customizedcast->setPredefinedKeyValue("sound", "chime");
            $customizedcast->setCustomizedField("type", $data['contentType']);
            $customizedcast->setCustomizedField("value", $data['contentValue']);
            $customizedcast->setAppMasterSecret($this->iosMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->iosKey);
        }
        $customizedcast->setPredefinedKeyValue("filter", $filter);
        $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        //        $customizedcast->setPredefinedKeyValue("alias", $data['alias']);
        //        $customizedcast->setPredefinedKeyValue("alias_type", $data['alias_type']);
        $customizedcast->setPredefinedKeyValue("production_mode", "true");
        return $customizedcast->send();

    }

    /**
     * 所有设备进行推送
     * @param array $data
     *                   $data['title'] 推送title
     *                   $data['value'] 推送文本内容
     * @return bool
     */
    public function pushAll($data) {
        $filter = array(
            "where" => array(
                "and" => array(
                    array(
                        "tag" => $data['tag']
                    ),
                )
            )
        );
        if ($data['phoneType'] == Enum_Platform::PLATFORM_ID_ANDROID) {
            $brocast = new Push_Umeng_AndroidBroadcast();
            $brocast->setPredefinedKeyValue("ticker", $data['title']);
            $brocast->setPredefinedKeyValue("title", $data['title']);
            $brocast->setPredefinedKeyValue("text", $data['value']);
            if ($data['contentType'] && $data['contentValue']) {
                $brocast->setPredefinedKeyValue("custom", json_encode(array('type' => $data['contentType'], 'value' => $data['contentValue'])));
                $brocast->setPredefinedKeyValue("after_open", "go_custom");
            } else {
                $brocast->setPredefinedKeyValue("after_open", "go_app");
            }
            $brocast->setAppMasterSecret($this->androidMasterSecret);
            $brocast->setPredefinedKeyValue("appkey", $this->androidKey);
        } else {
            $brocast = new Push_Umeng_IOSBroadcast();
            $brocast->setPredefinedKeyValue("alert", $data['title']);
            $brocast->setPredefinedKeyValue("badge", 0);
            $brocast->setPredefinedKeyValue("sound", "chime");
            $brocast->setCustomizedField("type", $data['contentType']);
            $brocast->setCustomizedField("value", $data['contentValue']);
            $brocast->setAppMasterSecret($this->iosMasterSecret);
            $brocast->setPredefinedKeyValue("appkey", $this->iosKey);
        }
        $brocast->setPredefinedKeyValue("filter", $filter);
        $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);
        return $brocast->send();
    }
}

