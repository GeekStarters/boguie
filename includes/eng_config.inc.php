<?php
if(!defined('LOCAL_MODE')) {
	die('<span style="font-family: tahoma, arial; font-size: 11px">config file cannot be included directly');
}

if(LOCAL_MODE){
    $ARR_CFGS["db_host"] = 'localhost';
	$ARR_CFGS["db_name"] = 'gs_geotaxi';
    $ARR_CFGS["db_user"] = 'root';
    $ARR_CFGS["db_pass"] = 'root';
	define('SITE_SUB_PATH', '/cab/');
}else {
    $ARR_CFGS["db_host"] = 'localhost';
	$ARR_CFGS["db_name"] = 'gs_geotaxi';
    $ARR_CFGS["db_user"] = 'root';
    $ARR_CFGS["db_pass"] = 'root';
	define('SITE_SUB_PATH', '/PATH FROM ROOT/'); // please replace "PATH FROM ROOT" with your path from root here. If your application is in root, leave it as /
}

define('SITE_WS_PATH', 'http://'.$_SERVER['HTTP_HOST'].SITE_SUB_PATH);

define('UP_FILES_FS_PATH', SITE_FS_PATH.'/uploaded_files');
define('UP_FILES_WS_PATH', SITE_WS_PATH.'/uploaded_files');

define('DEFAULT_START_YEAR', 2006);
define('DEFAULT_END_YEAR', date('Y')+10);

define('TEST_MODE', false);

define('CURRANCY_SYMBOL', '$');
define('CURRANCY', 'USD');

define('DEF_PAGE_SIZE', 12);
define('ADMIN_DIR', 'admin');

define("ADMIN_NAME","CAB Booking Application");
define("ADMIN_EMAIL","contact@eprofitbooster.com");
?>