<?php
include_once '../includes/db_functions.php';
$db = new DB_Functions();


    // $sel_query = mysql_query("SELECT * FROM gcm_users where email='$driver_email' ");
     //$row = mysql_fetch_array($sel_query);
         
    $driver_regID[] = "APA91bEXdIXd8Ne5FpsvqIQfN_tQ-wrPGVSx9uqUNxKpAWOhWfh4I9hmFBEC3dliIMn6NsA9BUsm2sxIVtyIf18tORCgk4z7FNd0VcZcFzMHIPqeSi6SJtaYMZJnIw_rZU7E0FEKIomu_uJkZIUF3LBVf5q63TkowA";
     
     
     
    //$regId = $_GET["regId"];
    //$newDate = date("M d Y", strtotime($pick_date));
    //$time = date("g:i a", strtotime($pick_time));

    $msg ="mensaje de prueba";

    include_once '../includes/GCM.php';

    $gcm = new GCM();

    $registatoin_ids = $driver_regID;
    $message = array("ride_now_confirm_msg" => $msg);

   $result = $gcm->send_notification($registatoin_ids, $message);
    print_r($result)
?>