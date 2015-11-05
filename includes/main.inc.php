<?php
error_reporting(E_ERROR | E_PARSE);

ob_start();
session_start();

if ($_SERVER['HTTP_HOST'] == "localhost") {
    define('LOCAL_MODE', true);
} else {
 	define('LOCAL_MODE', false);
}

$_SESSION['lang']	=	isset($_SESSION['lang'])?$_SESSION['lang']:"English";
$tmp = dirname(__FILE__);
$tmp = str_replace('\\' ,'/',$tmp);
$tmp = substr($tmp, 0, strrpos($tmp, '/'));
define('SITE_FS_PATH', $tmp); 

if($_SESSION['lang']	==	"English"){ 
	require_once(SITE_FS_PATH."/includes/eng_config.inc.php");
	require_once(SITE_FS_PATH."/includes/funcs_lib.inc.php");
	require_once(SITE_FS_PATH."/includes/funcs_cur.inc.php");
	require_once(SITE_FS_PATH."/includes/arrays.inc.php");
	require_once(SITE_FS_PATH."/includes/crypt.php");
	require_once(SITE_FS_PATH."/includes/english.php");
	require_once(SITE_FS_PATH."/includes/myfunctions.php");
	require_once(SITE_FS_PATH."/functions.php");
	//require_once(SITE_FS_PATH."/fbaccess.php");
	
	$siteRootValues	=	siteMainData();
	define("SITEROOT",$siteRootValues[admin_site_root]);
	define("FROMSITETITLE",$siteRootValues[admin_site_owner]);
	define('SITE_NAME', $siteRootValues[admin_site_owner]);
	define('SITE_TITLE', $siteRootValues[admin_site_owner]);
}else{	
	require_once(SITE_FS_PATH."/includes/config.inc.php");
}

if(strtolower($_SERVER['HTTPS'])=='on'){
	define('IN_SSL', true);
	define('HTTP_OR_HTTPS_PATH', SITE_SSL_PATH);
}else{
	define('IN_SSL', false);
	define('HTTP_OR_HTTPS_PATH', SITE_WS_PATH);
}

define('SCRIPT_START_TIME', getmicrotime());

if(get_magic_quotes_gpc()==0){
	$_GET		= ms_addslashes($_GET);
	$_POST		= ms_addslashes($_POST);
	$_COOKIE	= ms_addslashes($_COOKIE);
	@extract($_GET);
	@extract($_POST);
}else{
	$_GET		= ms_trim($_GET);
	$_POST		= ms_trim($_POST);
	$_COOKIE	= ms_trim($_COOKIE);
	import_request_variables('gp');
}

if(get_magic_quotes_runtime()) {
	set_magic_quotes_runtime(0);
}

if ($handle = opendir(SITE_FS_PATH.'/'.PLUGINS_DIR)) { 
   while (false !== ($file = readdir($handle))) { 
       if ($file != "." && $file != "..") { 
		   $curr_dir = SITE_FS_PATH.'/'.PLUGINS_DIR.'/'.$file;

           if(is_dir($curr_dir)) {
			   if(file_exists($curr_dir.'/plugin.php')) {
				   require_once($curr_dir.'/plugin.php');
			   }
		   }
       } 
   } 
   closedir($handle); 
} 

// Protect admin pages

define('MYSQL_DATE',date('Y-m-d'));
define('MYSQL_DATE_TIME',date('Y-m-d H:i:s'));

$admin_email	=	searchSingleRecord("tbl_config","config_value","config_id",1);
define('ADMIN_EMAIL', $admin_email);

$PHP_SELF = $_SERVER['PHP_SELF'];
$cur_page = basename($_SERVER['PHP_SELF']);
$admin_pos  = strpos($PHP_SELF, '/'.ADMIN_DIR.'/');

if($admin_pos!== false) {
	$adm_mysql_date=date('Y-m-d');
	$adm_mysql_date_time=date('Y-m-d H:i:s');	
}elseif(!empty($page_array) && in_array($cur_page,$page_array)){
	validate_user();
}
?>