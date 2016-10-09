<?php

// udpate driver lat and long in nearest driver tbl

if (isset($_REQUEST["d_email"]) && isset($_REQUEST["d_lat"]) && isset($_REQUEST["d_long"]) && isset($_REQUEST["noti_user_email"]) && isset($_REQUEST["d_cabtype"]) && isset($_REQUEST["driver_status"])) {

    $email = $_REQUEST["d_email"];
    $lat = $_REQUEST["d_lat"];
    $long = $_REQUEST["d_long"];
    $user_mail = $_REQUEST["noti_user_email"];
    $cab_type = $_REQUEST["d_cabtype"];
    $driver_status = $_REQUEST["driver_status"];

    // Store user details in db
    include_once '../includes/db_functions.php';

    $db = new DB_Functions();

    $res = $db->updateDriverPos($email, $lat, $long , $user_mail, $cab_type, $driver_status);
    $response = array();
    if($res){
        $response['success'] = 1;
      //echo  json_encode($response);
    }else{
        $response['success'] = 0;
     //echo   json_encode($response);
    }
} else {
    echo "not getting driver information";
}
?>
