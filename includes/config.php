<?php
date_default_timezone_set('America/Mexico_City');
/**
 * Database config variables
 */
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
define("DB_DATABASE", "gs_geotaxi");



/*
 * Google API Key
 */
define("GOOGLE_API_KEY", "AIzaSyAmhIz5nuhrE98tK3pN7ILHPd0mns3FlK4"); // Place your Google API Key

//define("518661517830", "AIzaSyCr1Ce41n5kYW3pAEil4vizvLC5kuLvvy8"); // Place your Google API Server Key



$root_path = '/PATH FROM ROOT/admin/'; // please replace "PATH FROM ROOT" with your path from root here. If your application is in root, leave it as /admin/
$root_path1 = '/PATH FROM ROOT';// please replace "PATH FROM ROOT" with your path from root here. If your application is in root, leave it as /
$dirroot_path = $_SERVER['DOCUMENT_ROOT'] . 'PATH FROM ROOT/admin/';// please replace "PATH FROM ROOT" with your path from root here. If your application is in root, leave it as /
$dirroot_path1 = $_SERVER['DOCUMENT_ROOT'] . 'PATH FROM ROOT/';// please replace "PATH FROM ROOT" with your path from root here. If your application is in root, leave it as /
$host = "http://$_SERVER[HTTP_HOST]";
$completelink= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$admin_mail="contact@eprofitbooster.com";

define("PROJECT_NAME","BookMyCab")

?>