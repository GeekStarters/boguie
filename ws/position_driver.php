<?php

// response json
$json = array();

if (isset($_REQUEST["lat"]) && isset($_REQUEST["long"]) && isset($_REQUEST["email"])) {
    $driver_details = array();
    $email = $_REQUEST["email"];
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];


    // Store user details in db
    include_once '../includes/db_functions.php';
    $db = new DB_Functions();
    $info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];
    $current_date = "$year-$month-$date $hour:$min:$sec";


    $sql_id=mysql_query("Select * from nearest_driver where driver_email='".$email."'");
    $contar= @mysql_num_rows($sql_id);

    if ($contar > 0) {
        mysql_query("update nearest_driver set latitude='".$lat."',longitude='".$long."',updated_on='".$current_date."' where driver_email='".$email."'"); 
    }else{
        mysql_query("INSERT INTO nearest_driver(driver_email,latitude,longitude,driver_status,updated_on) VALUES ('".$email."', '".$lat."', '".$long."','available','".$current_date."')"); 
    }

}
echo ("update nearest_driver set latitude='".$lat."',longitude='".$long."',updated_on='".$current_date."' where driver_email='".$email."'"); 

?>