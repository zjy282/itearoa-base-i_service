<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(1);
date_default_timezone_set('PRC');
require '../vendor/autoload.php';
define('APPLICATION_PATH', dirname(__FILE__) . "/../");
$application = new Yaf_Application(APPLICATION_PATH . "/env/application.ini");
$application->bootstrap()->run();
