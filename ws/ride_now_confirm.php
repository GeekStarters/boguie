<?php

include_once '../includes/db_functions.php';

$db = new DB_Functions();
if (isset($_REQUEST["unique_id"]) && isset($_REQUEST["user_type"]) && isset($_REQUEST["confirm_reject_cab"])) {

    $unique_id = $_REQUEST["unique_id"];
    $user_type = $_REQUEST["user_type"];
    $ride_status = $_REQUEST["confirm_reject_cab"];

    $sel_stat = mysql_fetch_object(mysql_query("select * from tbl_ride where id='$unique_id'"));
    $stat = $sel_stat->ride_status;
    $driver_id = $sel_stat->driver;
    $passenger_id = $sel_stat->passenger;

    $sel_driver_data = mysql_fetch_object(mysql_query("select * from tbl_user where id='$driver_id'"));
    $driver_email = $sel_driver_data->email;

    $sel_pass_data = mysql_fetch_object(mysql_query("select * from tbl_user where id='$passenger_id'"));
    $user_email = $sel_pass_data->email;

//pending

    if ($stat != 'reject') {
        $update_status = "update tbl_ride set ride_status='reject' where id='$unique_id' ";
        $update_status_exe = mysql_query($update_status);
        if($user_type=="driver"){
            $tipo="carrera_rechazada_taxista";
            $sel_query = mysql_query("SELECT * FROM gcm_users where email='$user_email'");
            $msg = "Su reserva ha sido rechazada por el cliente";
        }else{
            $tipo="carrera_rechazada_cliente";
            $sel_query = mysql_query("SELECT * FROM gcm_users where email='$driver_email'");
            $msg = "Su reserva ha sido rechazada por conductor";
        }

        $row = mysql_fetch_array($sel_query);
        $user_regID[] = $row['gcm_regid'];
        include_once '../includes/GCM.php';
        $gcm = new GCM();
        $registatoin_ids = $user_regID;
        $message = array($tipo => $msg);
        $result = $gcm->send_notification($registatoin_ids, $message);
    }else{
        $update_status = "update tbl_ride set ride_status='confirm' where id='$unique_id' ";
        $update_status_exe = mysql_query($update_status);
        $sel_query = mysql_query("SELECT * FROM gcm_users where email='$user_email' ");
        $msg = "Su taxi ya se dirige a su localización";
        $row = mysql_fetch_array($sel_query);
        $user_regID[] = $row['gcm_regid'];
        include_once '../includes/GCM.php';
        $gcm = new GCM();
        $registatoin_ids = $user_regID;
        $message = array("taxi_en_camino" => $msg);
        $result = $gcm->send_notification($registatoin_ids, $message);
    }
}
echo "string";
/*
    if ($stat != 'reject') {
       
        $update_status = "update tbl_ride set ride_status='$ride_status' where id='$unique_id' ";
        $update_status_exe = mysql_query($update_status);

        if ($stat == 'confirm') {
            //echo $ride_status;
            if ($ride_status == 'reject') {
                // echo $user_type;
                if ($user_type == 'driver') {
                    $sel_query = mysql_query("SELECT * FROM gcm_users where email='$user_email' ");
                    $row = mysql_fetch_array($sel_query);
                    $user_regID[] = $row['gcm_regid'];
                    $msg = "Your Booking has been Rejected by Driver ";
                    include_once '../includes/GCM.php';

                    $gcm = new GCM();

                    $registatoin_ids = $user_regID;
                    $message = array("ride_now_reject_msg" => $msg);

                    $result = $gcm->send_notification($registatoin_ids, $message);
                } else {
                    $sel_query = mysql_query("SELECT * FROM gcm_users where email='$driver_email' ");
                    $row = mysql_fetch_array($sel_query);
                    $driver_regID[] = $row['gcm_regid'];
                    $msg = "Your Booking has been Rejected by Passenger ";
                    //echo "siii";
                    include_once '../includes/GCM.php';

                    $gcm = new GCM();

                    $registatoin_ids = $driver_regID;
                    $message = array("ride_now_reject_msg" => $msg);

                    $result = $gcm->send_notification($registatoin_ids, $message);
                }
            }
        }
    }
    $response = array();
    if ($update_status_exe) {
        $response['success'] = '1';
        $response['status'] = "$ride_status";
        $response['user_type'] = "$user_type";
        echo json_encode($response);
    } else {
        $response['success'] = '0';
        $response['status'] = "$ride_status";
        $response['user_type'] = "$user_type";
        echo json_encode($response);
    }

    //entries in payment table
    $sel_values = mysql_query("select * from tbl_ride where id='$unique_id' and ride_status='confirm' ");
    $sel_count = mysql_num_rows($sel_values);
    if ($sel_count > 0) {
        $values = mysql_fetch_array($sel_values);
        $driver_id = $values['driver'];
        $passenger_id = $values['passenger'];
        $pickup_date = $values['pickup_date'];
        $pickuptime = $values['pickuptime'];
        $pickup_address = $values['pickup_address'];
        $dropoff_address = $values['dropoff_address'];
        $distance = $values['distance'];
        $cab_number = $values['cab_number'];

        $sel_pay_values = mysql_query("select * from tbl_payments where passenger_id='$passenger_id' and driver_id='$driver_id' and pickup_date='$pickup_date' and pickup_time='$pickuptime'");
        $count = mysql_num_rows($sel_pay_values);
        if ($count == 0) {
            $ins_pay = "insert into tbl_payments (`passenger_id`,`driver_id`,`pickup_date`,`pickup_time`,`pickup_address`,`dropoff_address`,`distance`,`cab_number`,`status`) "
                    . "values ('$passenger_id','$driver_id','$pickup_date','$pickuptime','$pickup_address','$dropoff_address','$distance','$cab_number','pending')";
            mysql_query($ins_pay);
        }
    }
}*/
?>