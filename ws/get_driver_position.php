<?php

// response json
$json = array();
if (isset($_REQUEST["id"])) {
    
    $id = $_REQUEST["id"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();
   // echo ("SELECT * from tbl_ride,tbl_user,nearest_driver where tbl_ride.id='".$id."' and tbl_ride.driver=tbl_user.id and tbl_user.email=nearest_driver.driver_email");


    $sql_direccion=mysql_query("SELECT * from tbl_ride,tbl_user,nearest_driver where tbl_ride.id='".$id."' and tbl_ride.driver=tbl_user.id and tbl_user.email=nearest_driver.driver_email");
    while ($fila=mysql_fetch_array($sql_direccion)) {
        $json['lat'] = $fila['latitude'];
        $json['lon']=$fila['longitude'];
        $json['updated_on']=$fila['updated_on'];
    }

    echo json_encode($json);
}
?>