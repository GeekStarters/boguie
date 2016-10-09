<?php
include_once '../includes/db_functions.php';
    $db = new DB_Functions();
	$response = array();
	mysql_query("SET NAMES 'utf8'");
	if (isset($_REQUEST["email"])) {
	    $user_email = $_REQUEST["email"];

	    $sel_passenger = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));
	    $user_id = $sel_passenger->id;
	    //echo ("SELECT *,tbl_ride.discount AS descuento,tbl_ride.id AS id_carrera FROM tbl_ride  INNER JOIN tbl_user ON tbl_ride.passenger=tbl_user.id WHERE tbl_ride.driver = '$user_id' AND (ride_status!='confirmed' AND ride_status!='confirm') ORDER BY tbl_ride.id  DESC LIMIT 100");

	    $query =  mysql_query("SELECT *,tbl_ride.discount AS descuento,tbl_ride.id AS id_carrera FROM tbl_ride  INNER JOIN tbl_user ON tbl_ride.passenger=tbl_user.id WHERE tbl_ride.driver = '$user_id' AND (ride_status!='confirmed' AND ride_status!='confirm') ORDER BY tbl_ride.id  DESC LIMIT 50");
	    $item = array();
	    $total=mysql_num_rows($query);
	    while($row = mysql_fetch_array($query)){
	        $item['id'] = $row["id_carrera"];
	        $item['passenger_name'] = $row["fullname"];
	        $item['passenger_phone'] = $row["mobile"];
	        $item['pickup_date'] = $row["pickup_date"];
	        $item['pickuptime'] = $row["pickuptime"];
	        $item['payment_method'] = $row["payment"];
	        $item['house'] = $row["house"];
	        $item['reference'] = $row["reference"];
	        $item['pickup_address'] = $row["pickup_address"];
	        $item['dropoff_address'] = $row["dropoff_address"];
	        $item['ride_status'] = $row["ride_status"];
			$item['start_geo'] = $row["start_geo"];
			$item['finish_geo'] = $row["finish_geo"];
			$item['descuento'] = $row["descuento"];
	        $item['status'] = $row["status"];
	        array_push($response, $item);
	    }
	    //echo $total;
	    if($total==0){
 			echo  json_encode("[{}]");
	    }else{
    	 echo  json_encode($response);
	    }
	   
	}
?>