<?php

// response json
$json = array();

/**
 * Store user's lat and long in tbl
 */
if (isset($_REQUEST["id"])) {
    $driver_details = array();
    $banner_details = array();
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    $ride_id = $_REQUEST["id"];
    $push_active = $_REQUEST["push_active"];

    // Store user details in db
    include_once '../includes/db_functions.php';
    $db = new DB_Functions();

    include_once '../includes/GCM.php';
    //$min_distance = "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
      //  . "AS distance FROM nearest_driver HAVING distance < 250 and driver_status = 'available' ORDER BY distance";

$min_distance = mysql_query("SELECT ( 3959 * acos( cos( radians($lat) ) * cos( radians( nearest_driver.latitude ) ) * cos( radians( nearest_driver.longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( nearest_driver.latitude ) ) ) ) "
        . "AS distance,nearest_driver.id,nearest_driver.user_email,nearest_driver.latitude,nearest_driver.longitude,nearest_driver.cab_type,nearest_driver.driver_status,nearest_driver.updated_on,nearest_driver.updated_on,tbl_user.status,nearest_driver.driver_email,tbl_user.email FROM nearest_driver,tbl_user HAVING distance < 19 and driver_status = 'available' and nearest_driver.driver_email=tbl_user.email and tbl_user.status='Active' ORDER BY distance LIMIT 15");


    //banner
    $banner=mysql_query("Select * from publicidad where status='active' ORDER BY RAND() LIMIT 1");
    while ($rowBanner = mysql_fetch_array($banner)) {
        $banner_details['src'] = "http://45.55.20.224/boguie/ads/".$rowBanner['src_banner'];
        $banner_details['url'] = $rowBanner['url_open'];
    }
    /// Enviar push a cada usuario cercano y regresar resultados
    $drivers= array();
    $driver_regID= array();
    $count=@mysql_num_rows($min_distance);

    while ($row = mysql_fetch_array($min_distance)) {
        $driver= array();


        $ultima_fecha=$row['updated_on'];
        $info = getdate();
        $date = $info['mday'];
        $month = $info['mon'];
        $year = $info['year'];
        $hour = $info['hours'];
        $min = $info['minutes'];
        $sec = $info['seconds'];
        $current_date = "$year-$month-$date $hour:$min:$sec";
        $timeFirst  = strtotime($ultima_fecha);
        $timeSecond = strtotime($current_date);
        $differenceInSeconds = $timeSecond - $timeFirst;
        if($differenceInSeconds<1800){

            $sql_gcm=mysql_query("Select * from gcm_users where email='".$row['driver_email']."' and user_type='driver' and driver_status='available' and gcm_regid!=''");
            while ($fila=mysql_fetch_array($sql_gcm)) {
                $driver_regID[] = $fila['gcm_regid'];
                if($push_active=="active"){
                    $info = getdate();
                    $date = $info['mday'];
                    $month = $info['mon'];
                    $year = $info['year'];
                    $hour = $info['hours'];
                    $min = $info['minutes'];
                    $sec = $info['seconds'];
                    $current_date = "$year-$month-$date $hour:$min:$sec";
                    mysql_query("UPDATE gcm_users SET recieved_at='".$current_date."' WHERE gcm_regid='$driver_gcm'");
                }
            }

            $sql_user=mysql_query("Select * from tbl_user where email='".$user_email."' LIMIT 1");
            while ($fila_user=mysql_fetch_array($sql_user)) {
                $user_name= $fila_user['fullname'];
                $user_no= $fila_user['mobile'];
            }


            $newDate = date("M d Y", strtotime($pick_date));
            $time = date("g:i a", strtotime($pick_time));
            $driver['latitude'] = $row['latitude'];
            $driver['longitude'] = $row['longitude'];
            $driver['email'] = $row['driver_email'];
            $driver['id_carrera'] = "$ride_id";
            array_push($drivers, $driver);
        }
    }


    
} else {
    echo "not getting user information";
}

echo '{"conductor":'.json_encode($drivers).',"banner":'.json_encode($banner_details).'}';
?>