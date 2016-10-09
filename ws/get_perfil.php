<?php
header('Content-Type: application/json');
$json = array();
// Store user details in db
include_once '../includes/db_functions.php';
$db = new DB_Functions();
if (isset($_REQUEST["email"])) {
	$sql=mysql_query("SELECT * FROM tbl_user WHERE email='".$_REQUEST["email"]."'");
	$details = array();
	while ($filas=mysql_fetch_array($sql)) {
	  $details['fullname'] = $filas['fullname'];
	  $details['birthday'] = $filas['birthday'];
	  $details['mobile'] = $filas['mobile'];
	}
	
}
echo json_encode($details);
?>