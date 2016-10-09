<?php
$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];
echo $current_date = "$year-$month-$date $hour:$min:$sec";
/*
$json = array();

if (isset($_REQUEST["lat"]) && isset($_REQUEST["long"]) && isset($_REQUEST["email"])) {
    $driver_details = array();
    $email = $_REQUEST["email"];
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    $db = new DB_Functions();


    mysql_query("INSERT INTO nearest_driver2(driver_email,latitude,longitude,driver_status) VALUES ('".$email."', '".$lat."', '".$long."','available')"); 
    echo "INSERT INTO nearest_driver2(driver_email,latitude,longitude,driver_status) VALUES ('".$email."', '".$lat."', '".$long."','available')";
}
*/
?>