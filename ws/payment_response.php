<?php

include ('../includes/constant.php');
include ('../includes/database_connection.php');
$response = array();
if ($_REQUEST['payment_id'] && $_REQUEST['trans_id'] && $_REQUEST['trans_state']) {

    $payment_id = $_REQUEST['payment_id'];
    $trans_id = $_REQUEST['trans_id'];
    $trans_state = $_REQUEST['trans_state'];

    $update_status = mysql_query("update tbl_payments set transaction_id='$trans_id' ,status='$trans_state' where payment_id='$payment_id' ");
    if ($update_status) {
        $response['success'] = 1;
        echo json_encode($response);

        $sel_data = mysql_query("select * from tbl_payments where payment_id='$payment_id' ");
        $data = mysql_fetch_array($sel_data);
        // update ride status in tbl_ride

        $update_ride_status = mysql_query("update tbl_ride set ride_status='completed' where driver='" . $data['driver_id'] . "' and passenger='" . $data['passenger_id'] . "' and pickup_date='" . $data['pickup_date'] . "' and pickuptime='" . $data['pickup_time'] . "' and distance='" . $data['distance'] . "' ");

        //send notification of payment to users
        $sel_passenger = mysql_fetch_array(mysql_query("select * from tbl_user where id='" . $data['passenger_id'] . "' "));
        $row = mysql_fetch_array(mysql_query("SELECT * FROM gcm_users where email='" . $sel_passenger['email'] . "' "));

        $user_regID[] = $row['gcm_regid'];
        $msg = "Your Payment has been done successfully";

        include_once '../includes/GCM.php';

        $gcm = new GCM();

        $registatoin_ids = $user_regID;
        $message = array("passenger_payment_msg" => $msg);

        $result = $gcm->send_notification($registatoin_ids, $message);


        $sel_driver = mysql_fetch_array(mysql_query("select * from tbl_user where id='" . $data['driver_id'] . "' "));
        $row2 = mysql_fetch_array(mysql_query("SELECT * FROM gcm_users where email='" . $sel_driver['email'] . "' "));

        $driver_regID[] = $row2['gcm_regid'];
        $msg2 = "Your Payment has been done successfully";

        include_once '../includes/GCM.php';

        $gcm2 = new GCM();

        $registatoin_ids2 = $driver_regID;
        $message2 = array("driver_payment_msg" => $msg2);

        $result2 = $gcm2->send_notification($registatoin_ids2, $message2);
    } else {
        $response['success'] = 0;
        echo json_encode($response);
    }
}
?>