<?php

include_once 'config.php';


//Connect to MySql Database
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
    die('Could not Connect Database : ' . mysql_error());
}

//Select MySql Database Name

mysql_select_db(DB_DATABASE) or die('Could not Select Database' . mysql_error());



session_start();
ob_start();
error_reporting(E_ALL ^ E_NOTICE);

function admin_redirect() {
    if ($_SESSION['admin_username'] == "") {
        header("location:index.php");
    }
}

?>