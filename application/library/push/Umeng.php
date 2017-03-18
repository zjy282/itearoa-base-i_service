<?php

/**
 * 有盟推送
 *
 */
class Push_Umeng {

    const PLATFORM = 'umeng';

    private static $config = array();

    private static function getConfig() {
        if (empty(self::$config)) {
            self::$config = Enum_Push::getConfig(self::PLATFORM);
        }
    }
    
}

?>
