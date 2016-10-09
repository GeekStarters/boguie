<?php
include_once '../includes/db_functions.php';
require_once("../admin/includes/main.inc.php");
    $db = new DB_Functions();
	$response = array();
	if (isset($_REQUEST["email"])) {
	    $user_email = $_REQUEST["email"];

	    $sel_passenger = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));
	    $user_id = $sel_passenger->id;
	    $user_name = $sel_passenger->fullname;
	    $user_no = $sel_passenger->mobile;

	    //echo "SELECT * FROM tbl_ride INNER JOIN tbl_cab ON tbl_ride.cab=tbl_cab.id INNER JOIN tbl_user ON tbl_ride.driver=tbl_user.id WHERE tbl_ride.passenger = $user_id AND tbl_ride.ride_type = 'reservation'";
	    $query =  mysql_query("SELECT * FROM tbl_ride INNER JOIN tbl_cab ON tbl_ride.cab=tbl_cab.id INNER JOIN tbl_user ON tbl_ride.driver=tbl_user.id WHERE tbl_ride.passenger = '$user_id' AND tbl_ride.ride_type = 'reservation' ");
	    $item = array();
	    while($row = mysql_fetch_array($query)){
	        $item['id'] = $row["id"];
	        $item['driver'] = $row["driver"];
	        $item['cab'] = $row["cab"];
	        $item['cab_name'] = $row["cab_number"];
	        $item['cab_image'] = $row["cab_image1"];
	        $item['cab_manufacter'] = $row["cab_manufacter"];
	        $item['cab_plate'] = $row["cab_plate"];
	        $item['cab_year'] = $row["cab_year"];
	        $item['cab_year'] = $row["cab_year"];
	        $item['cab_year'] = $row["cab_year"];
	        $item['driver_name'] = $row["fullname"];
	        $item['driver_phone'] = $row["mobile"];
	        $item['driver_photo'] = $row["image"];
	        $item['pickup_time'] = $row["pickup_time"];
	        $item['payment_method'] = $row["payment"];
	        $item['house'] = $row["house"];
	        $item['reference'] = $row["reference"];
	        $item['pickup_address'] = $row["pickup_address"];
	        $item['dropoff_address'] = $row["dropoff_address"];
	        $item['ride_status'] = $row["ride_status"];
	        $item['status'] = $row["status"];
	        array_push($response, $item);
	    }
	    echo  json_encode($response);
	}
?>