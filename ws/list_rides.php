<?php
include_once '../includes/db_functions.php';
    $db = new DB_Functions();
	$response = array();
	$info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];
    $current_date = "$year-$month-$date $hour:$min:$sec";
    $timeSecond = strtotime($current_date);
    

	//if (isset($_REQUEST["email"])) {
	    //$user_email = $_REQUEST["email"];
	    $query =  mysql_query("SELECT *,tbl_ride.discount AS descuento,tbl_ride.id AS id_carrera,tbl_ride.latitude AS lat,tbl_ride.longitude AS lon FROM tbl_ride  INNER JOIN tbl_user ON tbl_ride.passenger=tbl_user.id WHERE tbl_ride.ride_type!= 'reservation' AND tbl_ride.start_geo='' AND tbl_ride.finish_geo='' and tbl_ride.driver='0' ORDER BY tbl_ride.id DESC Limit 0,100");
	    $item = array();
	    while($row = mysql_fetch_array($query)){
	    	$dateServer = $row["pickup_time"];
	    	$timeFirst  = strtotime($dateServer);
			$differenceInSeconds = $timeSecond - $timeFirst;
			if($differenceInSeconds<300){
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
		        $item['latitude'] = $row["lat"];
		        $item['longitude'] = $row["lon"];
		        array_push($response, $item);
			}
	       
	    }
	    echo  json_encode($response);
	//}
?>