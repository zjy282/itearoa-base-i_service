<?php

class Interceptor_RecordConfig {

    private static $config = array(
        'Orderajax' => array(
            'moduleType' => 1,
            'action' => array(
                'changestatus' => 1,
                'confirm' => 1
            )
        )
    );

    /**
     * 获取拦截器配置
     *
     * @return array
     */
    public static function getConfig() {
        return self::$config;
    }
}

?>
