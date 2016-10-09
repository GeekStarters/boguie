<?php

// response json
$json = array();

/**
 * Store user's lat and long in tbl
 */
if (isset($_REQUEST["email_user"]) && isset($_REQUEST["description"]) && isset($_REQUEST["lat"]) && isset($_REQUEST["lon"]) && isset($_REQUEST["title"])) {
    
    $email_user = $_REQUEST["email_user"];
    $description = $_REQUEST["description"];
    $lat = $_REQUEST["lat"];
    $lon = $_REQUEST["lon"];
    $house = $_REQUEST["house"];
    $reference = $_REQUEST["reference"];
    $title = $_REQUEST["title"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();

    $sql_direccion=mysql_query("INSERT INTO tbl_address (title,email_user,description,lat,lon,house,reference) VALUES ('".$title."','".$email_user."','".$description."','".$lat."','".$lon."','".$house."','".$reference."')");
    $driver_details = array();
    $driver_details['success'] = "1";
    echo json_encode($driver_details);
}
?>