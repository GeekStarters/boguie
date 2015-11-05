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
	    $query =  mysql_query("SELECT * FROM tbl_ride  WHERE passenger = '$user_id' AND ride_type = 'reservation' AND ride_status = 'pending'");

	    while($row = mysql_fetch_array($query)){
	        $response['id'] = $row["id"];
	        $response['driver'] = $row["driver"];
	        $response['cab'] = $row["cab"];
	        $response['cab_name'] = $row["cab_number"];
	        $response['payment_method'] = $row["payment"];
	        $response['house'] = $row["house"];
	        $response['reference'] = $row["reference"];
	        $response['pickup_address'] = $row["pickup_address"];
	        $response['dropoff_address'] = $row["dropoff_address"];
	        $response['ride_status'] = $row["ride_status"];
	        $response['status'] = $row["status"];
	    }
	    echo  json_encode($response);
	}
?>