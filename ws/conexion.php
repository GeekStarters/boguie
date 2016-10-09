<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "root!");
define("DB_DATABASE", "gs_heytaxi");
// connecting to mysql
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
mysql_select_db(DB_DATABASE);
?>