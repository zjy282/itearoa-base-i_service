<?php
class Push {

    protected $appkey = NULL;

    protected $appMasterSecret = NULL;

    protected $timestamp = NULL;

    protected $validation_token = NULL;

    function __construct($key, $secret) {
        $this->appkey = $key;
        $this->appMasterSecret = $secret;
        $this->timestamp = strval(time());
    }

    public function pushSignel ($data){
            if ($data['phoneType'] == 2){
                $unicast = new Push_Umeng_AndroidUnicast();
                $unicast->setPredefinedKeyValue("ticker", $data['title']);//通知栏提示文字
                $unicast->setPredefinedKeyValue("title", $data['title']);
                $unicast->setPredefinedKeyValue("text", $data['value']);
                $unicast->setPredefinedKeyValue("after_open", "go_app");
            } else {
                $unicast = new Push_Umeng_IOSUnicast();
                $unicast->setPredefinedKeyValue("alert", $data['title']);
                $unicast->setPredefinedKeyValue("badge", 0);
                $unicast->setPredefinedKeyValue("sound", "chime");
            }
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey", $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
            $unicast->setPredefinedKeyValue("device_tokens", $data['dataid']);
            $unicast->setPredefinedKeyValue("production_mode", "true");
            $unicast->send();
    }

    public function pushAlais ($data){
            if ($data['phoneType'] == 2){
                $customizedcast = new Push_Umeng_AndroidCustomizedcast();
                $customizedcast->setPredefinedKeyValue("ticker", $data['title']);
                $customizedcast->setPredefinedKeyValue("title", $data['title']);
                $customizedcast->setPredefinedKeyValue("text", $data['value']);
                $customizedcast->setPredefinedKeyValue("after_open", "go_app");
            } else {
                $customizedcast = new Push_Umeng_IOSCustomizedcast();
                $customizedcast->setPredefinedKeyValue("alert", $data['title']);
                $customizedcast->setPredefinedKeyValue("badge", 0);
                $customizedcast->setPredefinedKeyValue("sound", "chime");
            }
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            $customizedcast->setPredefinedKeyValue("alias", $data['alias']);
            $customizedcast->setPredefinedKeyValue("alias_type", $data['alias_type']);
            $customizedcast->setPredefinedKeyValue("production_mode", "false");
            $customizedcast->send();
        
    }

    public function pushTag($data){
            $filter = array(
                "where" => array(
                    "and" => array(
                        array(
                            "tag" => $data['tag']
                        ),
                    )
                )
            );
            if ($data['phoneType'] == 2){
                $customizedcast = new Push_Umeng_AndroidGroupcast();
                $customizedcast->setPredefinedKeyValue("ticker", $data['title']);
                $customizedcast->setPredefinedKeyValue("title", $data['title']);
                $customizedcast->setPredefinedKeyValue("text", $data['value']);
                $customizedcast->setPredefinedKeyValue("after_open", "go_app");
            } else {
                $customizedcast = new Push_Umeng_IOSGroupcast();
                $customizedcast->setPredefinedKeyValue("alert", $data['title']);
                $customizedcast->setPredefinedKeyValue("badge", 0);
                $customizedcast->setPredefinedKeyValue("sound", "chime");
            }
            $customizedcast->setPredefinedKeyValue("filter", $filter);
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            $customizedcast->setPredefinedKeyValue("alias", $data['alias']);
            $customizedcast->setPredefinedKeyValue("alias_type", $data['alias_type']);
            $customizedcast->setPredefinedKeyValue("production_mode", "false");
            $customizedcast->send();
        
    }
    
    public function pushAll ($data){
        
    }

    public function sendIOSBroadcast() {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey", $this->appkey);
            $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);
            
            $brocast->setPredefinedKeyValue("alert", "IOS 广播测试");
            $brocast->setPredefinedKeyValue("badge", 0);
            $brocast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue("production_mode", "false");
            // Set customized fields
            $brocast->setCustomizedField("test", "helloworld");
            print("Sending broadcast notification, please wait...\r\n");
            $brocast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }
}

