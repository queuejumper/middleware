<?php
/**
AUTHOR: AHMED SALLAM
DESCRIPTION: THIS PAGE ACTS AS THE MAIN ROUTER FOR THE APPLICATION. EVERY REQUEST WILL GO THROUGH THIS PAGE
*/
use core\Run;
defined('ENV') or define('ENV','pro');
defined('BASE_DIR') or define('BASE_DIR',__DIR__);
define("DS", (ENV == "pro") ? "/middleware" : "");
require_once(BASE_DIR.'/vendor/autoload.php');
require_once(BASE_DIR.'/config/web.php');
if(ENV=="dev")
{
	error_reporting(-1);
	ini_set('display_errors', 'On');
}
$actual_link = (isset($_SERVER['HTTPS']) 
        ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$inst = new Run();
$inst->getUrl($actual_link)->route($config['urlManager']);
