<?php

// response json
$json = array();

/**
 * Store user's lat and long in tbl
 */
if (isset($_REQUEST["id"])) {
    $driver_details = array();
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    $ride_id = $_REQUEST["id"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    $db = new DB_Functions();

    include_once '../includes/GCM.php';
    $min_distance = "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
        . "AS distance FROM nearest_driver HAVING distance < 19 and driver_status = 'available' ORDER BY distance";
        

    /// Enviar push a cada usuario cercano y regresar resultados
    $drivers= array();
    $driver_regID= array();
    $count=@mysql_num_rows($min_distance);
    while ($row = mysql_fetch_array($min_distance)) {
        $driver= array();
        $sql_gcm=mysql_query("Select * from gcm_users where email='".$row['driver_email']."' and user_type='driver' and driver_status='available' and gcm_regid!=''");
        while ($fila=mysql_fetch_array($sql_gcm)) {
            $driver_regID[] = $fila['gcm_regid'];
        }

        $sql_user=mysql_query("Select * from tbl_user where email='".$user_email."' LIMIT 1");
        while ($fila_user=mysql_fetch_array($sql_user)) {
            $user_name= $fila_user['fullname'];
            $user_no= $fila_user['mobile'];
        }

        
        $newDate = date("M d Y", strtotime($pick_date));
        $time = date("g:i a", strtotime($pick_time));
        $msg ="[$user_name][$user_no][$newDate][$time][$pick_add][$dest_add][$insert_id][$discount]";
        $driver['latitude'] = $row['latitude'];
        $driver['longitude'] = $row['longitude'];
        $driver['email'] = $row['driver_email'];
        $driver['id_carrera'] = "$insert_id";
        array_push($drivers, $driver);
    }


    
} else {
    echo "not getting user information";
}


 
?>