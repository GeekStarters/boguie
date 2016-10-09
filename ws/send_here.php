<?php
	include_once '../includes/db_functions.php';
	$db = new DB_Functions();
	$id = $_REQUEST['id'];
	$newSql="SELECT tbl_user.email FROM tbl_ride, tbl_user WHERE tbl_ride.id ='".$id."' AND tbl_ride.passenger = tbl_user.id";
	//$newSql = "select *  from tbl_user where id='$passenger_id'";
	$newResult = mysql_query($newSql);
	$newRow = mysql_fetch_array($newResult);
	$passenger_email = $newRow["email"];
	$driver_regID= array();
	$sel_query = mysql_query("SELECT * FROM gcm_users where email='$passenger_email'");
	$row = mysql_fetch_array($sel_query);
	$driver_regID[] = $row['gcm_regid']; 

	include_once '../includes/GCM.php';
	$gcm = new GCM();
	$push_date = date("F j, Y, g:i a");
	$value = "Tu taxi esta aqui";
	$msg ="[$push_date][$value]";
	$registatoin_ids = $driver_regID;
	$message = array("estoy_aqui" => $msg);
	$result = $gcm->send_notification($registatoin_ids, $message);
?>