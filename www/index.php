<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(1);
date_default_timezone_set('PRC');
define('APPLICATION_PATH', dirname(__FILE__) . "/../");
$application = new Yaf_Application(APPLICATION_PATH . "/env/application.ini");
$application->bootstrap()->run();
