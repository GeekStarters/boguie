<?php
include_once '../includes/db_functions.php';
    $db = new DB_Functions();
	$response = array();
	if (isset($_REQUEST["id"])) {
	    $id = $_REQUEST["id"];
	    $reason = $_REQUEST["reason"];
	    $type_reason = $_REQUEST["type_reason"];
	    $query = "SELECT * FROM tbl_ride WHERE id = '$id'";
	    $result = mysql_query($query);
		$ride = mysql_fetch_object($result);
        
	    if ($ride -> ride_status == 'confirm') {
			$id_taxista=$ride -> driver;

	    	if($type_reason!="driver"){
				//obtener correo taxista
	            $sql_t=mysql_query("SELECT * FROM  tbl_user where id='".$id_taxista."'");
	            $row_t = mysql_fetch_array($sql_t);
	            $valueGCM=$row_t['email'];
	    	}else{
				$id_pasajero=$ride-> passenger;
	            $sql_t=mysql_query("SELECT * FROM  tbl_user where id='".$id_pasajero."'");
	            $row_t = mysql_fetch_array($sql_t);
	            $valueGCM=$row_t['email'];
	    	}

	    	//echo $valueGCM;
	    	 

			$driver_regID= array();
		    $sel_query = mysql_query("SELECT * FROM gcm_users where email='$valueGCM'");
		    $row = mysql_fetch_array($sel_query);
		  	//echo $row['gcm_regid'];
		    $driver_regID[] = $row['gcm_regid'];
			$msg = array();
    		$query = mysql_query("SELECT * FROM tbl_ride WHERE id = $id");
	    	while($row = mysql_fetch_array($query)){
	    		 $msg['id'] = $row["id"];
	    		 $msg['pickup_date'] = $row["pickup_date"];
	    		 $msg['pickup_time'] = $row["pickup_time"];
	        	 $msg['pickup_address'] = $row["pickup_address"];
	        	 $msg['passenger'] = $row["passenger"];
	    	}

			$user_id = $ride -> passenger;
	    	$strike = mysql_query("UPDATE tbl_user SET strike=strike + 1 WHERE id=$user_id");
	    	$check = "SELECT * FROM tbl_user WHERE id = $user_id";
	    	$check_result = mysql_query($check);
			$strike_value = mysql_fetch_object($check_result);
			if ($strike_value->strike > 3) {
				$deactivateUser = mysql_query("UPDATE tbl_user SET status='DEACTIVATED' WHERE id=$user_id");
			}

		    include_once '../includes/GCM.php';
		    $gcm = new GCM();
		    $registatoin_ids = $driver_regID;
		    $cancelar="cancelar";
		    $msgE ="[$cancelar][$unique_id]";
		    $message = array("cancelar_carrera" => $msgE);
		    $result = $gcm->send_notification($registatoin_ids, $message);


		    //pasar a disponible es estado del taxista
            $sql_id=mysql_query("Select * from tbl_user where id='".$id_taxista."'");
            $row_id = mysql_fetch_array($sql_id);
            $email_driver = $row_id["email"];
            mysql_query("UPDATE gcm_users SET driver_status='available' WHERE email='$email_driver'");
           	mysql_query("update nearest_driver set driver_status='available' where driver_email='".$email_driver."'");



			//$sql = "UPDATE tbl_ride SET ride_status='confirm' WHERE id = $id";
	    	$sql = "UPDATE tbl_ride SET ride_status='canceled', reason = '$reason',type_reason='".$type_reason ."' WHERE id = $id";
			$retval = mysql_query( $sql );
			if(! $retval )
			{
				$response['result'] = "Error";
			}else{
				$response['result'] = "Ok";
			}
			echo  json_encode($response);

	    }elseif ($ride -> ride_status == 'pending') {
	    	$sql = "UPDATE tbl_ride SET ride_status='canceled', reason = '$reason',type_reason='".$type_reason ."' WHERE id = $id";
			$retval = mysql_query( $sql );
			if(! $retval )
			{
				$response['result'] = "Error";
			}else{
				$response['result'] = "Ok";
			}
			echo  json_encode($response);
	    }else{
	    	$response['result'] = "Already canceled";
	    	echo  json_encode($response);
	    }
	}
?>