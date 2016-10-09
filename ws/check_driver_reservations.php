<?php
	include_once '../includes/db_functions.php';
    require_once("../admin/includes/main.inc.php");
    $db = new DB_Functions();
	$response = array();
	if (isset($_REQUEST["email"])) {
	    $user_email = $_REQUEST["email"];

	    $sel_driver = mysql_fetch_object(mysql_query("select * from tbl_user where email='$email'"));
    	$driver_id = $sel_driver->id;


	    $query = mysql_query("SELECT * FROM tbl_ride INNER JOIN tbl_user ON tbl_ride.passenger = tbl_user.id WHERE tbl_ride.driver='$driver_id' AND tbl_ride.ride_type = 'reservation' AND tbl_ride.status = 0 AND tbl_ride.ride_status = 'confirmed'");
	    $item = array();
	    while($row = mysql_fetch_array($query)){
	        $item['id'] = $row["id"];
	        $item['passenger'] = $row["passenger"];
	        $item['passenger_name'] = $row["fullname"];
	        $item['passenger_phone'] = $row["mobile"];
	        $item['passenger_photo'] = $row["image"];
	        $item['pickup_date'] = $row["pickup_date"];
	        $item['pickup_time'] = $row["pickup_time"];
	        $item['pickup_address'] = $row["pickup_address"];
	        $item['dropoff_address'] = $row["dropoff_address"];
	        $item['ride_status'] = $row["ride_status"];
	        $item['status'] = $row["status"];
	        array_push($stack, $item);
	    }
	    echo  json_encode($response);
	}
?>