<?php
include_once '../includes/db_functions.php';
//require_once("../admin/includes/main.inc.php");
    $db = new DB_Functions();
    mysql_query("SET NAMES 'utf8'");
	$response = array();
	if (isset($_REQUEST["email"])) {
	    $user_email = $_REQUEST["email"];

	    $sel_passenger = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));
	    $user_id = $sel_passenger->id;
	    $user_name = $sel_passenger->fullname;
	    $user_no = $sel_passenger->mobile;

	    //echo "SELECT * FROM tbl_ride INNER JOIN tbl_cab ON tbl_ride.cab=tbl_cab.id INNER JOIN tbl_user ON tbl_ride.driver=tbl_user.id WHERE tbl_ride.passenger = $user_id AND tbl_ride.ride_type = 'reservation'";
	    $query =  mysql_query("SELECT * FROM tbl_ride  WHERE passenger = '$user_id' AND ride_type='reservation' ORDER BY id DESC LIMIT 0,100");
	    $item = array();
	    while($row = mysql_fetch_array($query)){
	        $item['id'] = $row["id"];

	        if($row["ride_status"]=="confirmed"){
	    		$query_taxista=mysql_query("SELECT * FROM  tbl_user,tbl_cab where tbl_user.id='".$row["driver"]."' and tbl_user.taxi=tbl_cab.id");
				while($row_taxista = mysql_fetch_array($query_taxista)){
				 	$item['cab_name'] = $row_taxista["fullname"];
				 	$item['taxi'] = $row_taxista["cab_number"];
				 	$item['marca'] = $row_taxista["cab_manufacter"];
					$item['placa'] = $row_taxista["cab_plate"];
				 	$item['telefono'] = $row_taxista["mobile"];
				}
	    	}else{
				$item['cab_name']="-";
				$item['taxi'] = "-";
			 	$item['marca']  = "-";
				$item['placa']  = "-";
			 	$item['telefono']  = "-";
	    	}

	    	if($row["start_geo"]==""){
				$item['bt_visible']  = "true";
	    	}else{
				$item['bt_visible']  = "false";
	    	}
	        
	        $item['destino'] = $row["dropoff_address"];
	        $item['house'] = $row["house"];
	        $item['reference'] = $row["reference"];
	        $item['pickup_address'] = $row["pickup_address"];
	        $item['dropoff_address'] = $row["dropoff_address"];
	        $item['ride_status'] = $row["ride_status"];
	        $item['status'] = $row["ride_status"];
	        $item['pickup_date'] = $row["pickup_date"];
	        $item['pickuptime'] = $row["pickuptime"];


	       	array_push($response, $item);
	    }
	    echo  json_encode($response);
	}
?>