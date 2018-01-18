<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

date_default_timezone_set('PRC');
mb_internal_encoding('UTF-8');
define('APPLICATION_PATH', dirname(__FILE__) . "/../");

$app = new Yaf_Application(APPLICATION_PATH . "/env/application.ini");
$app->bootstrap();