<?php
// response json
$json = array();
// Store user details in db
include_once '../includes/db_functions.php';
$db = new DB_Functions();
if (isset($_REQUEST["fullname"]) && isset($_REQUEST["email"]) && isset($_REQUEST["mobile"])  && isset($_REQUEST["birthday"])) {
	$fullname=$_REQUEST["fullname"];
	$email=$_REQUEST["email"];
	$mobile=$_REQUEST["mobile"];
	$birthday=$_REQUEST["birthday"];
	$password=$_REQUEST["password"];
	$details = array();

	if($password!=""){
		$sql="update tbl_user set fullname='".$fullname."', mobile='".$mobile."', birthday='".$birthday."', password='".$password."' where email='".$email."'";
		$update = mysql_query($sql);
	}else{
		$sql="update tbl_user set fullname='".$fullname."', mobile='".$mobile."', birthday='".$birthday."' where email='".$email."'";
		$update = mysql_query($sql);
	}

	if ($update) {
		$details['success'] = "1";
		$details['msg'] = "Datos actualizados";
	}else{
		$details['success'] = "0";
		$details['msg'] = "Error, Intente mas tarde";
	}
	echo json_encode($details);
}
?>