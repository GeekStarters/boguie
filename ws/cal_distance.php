<?php

// response json
$json = array();

/**
 * Store user's lat and long in tbl
 */
if (isset($_REQUEST["email"]) && isset($_REQUEST["lat"]) && isset($_REQUEST["long"]) && isset($_REQUEST["cabtype"])) {
    
    $email = $_REQUEST["email"];
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    $cab_type = $_REQUEST["cabtype"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();
    
    $del = mysql_query("delete from nearest_driver where user_email='$email'");

    $res = $db->updatePos($email, $lat, $long, $cab_type);    
     //echo $success;
    
    // send notification to each driver
    
    $driver_regID= array();
     $sel_query = mysql_query("SELECT * FROM gcm_users where driver_status='available' ");
     while($row = mysql_fetch_array($sel_query)){
         
         $driver_regID[] = $row['gcm_regid'];
     }
     
     
    //$regId = $_GET["regId"];
    $message = "$email";
    
    include_once '../includes/GCM.php';
    
    $gcm = new GCM();

    $registatoin_ids = $driver_regID;
    $message = array("noti_data" => $message);

    $result = $gcm->send_notification($registatoin_ids, $message);

    
       /* $lat1 ="32.9697";
        $lon1 = "-96.80322";
        $lat2 ="29.46786";
        $lon2 = "-98.53506";
        $unit = "M";
        
        
        $miles = $db->distance($lat1, $lon1, $lat2, $lon2, $unit);
        echo round($miles,2);*/
    
    // calculate shortest distance between user and driver
        mysql_query("SELECT SLEEP(5)");
        
        $p_cab_type = $_REQUEST["cabtype"];
        if($p_cab_type == 1){
            $p_cab_type = 7;
        }else if($p_cab_type == 2){
            $p_cab_type = 8;
        }else{
            $p_cab_type = 9;
        }
        
        $min_distance = "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
        . "AS distance FROM nearest_driver HAVING distance < 250 and user_email='$email' and driver_status = 'available' and cab_type ='$p_cab_type' ORDER BY distance LIMIT 1";
        
        $min_distance_exe = mysql_query($min_distance);
        $row = mysql_fetch_array($min_distance_exe);
            $driver_details = array();
                  $id = $row['driver_email'];
                  $distance = round($row['distance'],2);  //distance in miles
                  $avg_speed = 18.64;  // 30kmphr
                  $reach_time = round(($distance/$avg_speed)*60 ,2);
                  
                  //echo "<br/>";
                  $driver_info = "select * from tbl_user where email='$id'";
                  $driver_data = mysql_fetch_object(mysql_query($driver_info));
                  $driver_name = $driver_data->fullname;
                    $driver_no = $driver_data->mobile;
                     $driver_cab = $driver_data->cab_no;
              
                     $driver_details['distance'] = "$distance";
                     $driver_details['reach_time'] = "$reach_time";
                     $driver_details['name'] = "$driver_name";
                     $driver_details['number'] = "$driver_no";
                     $driver_details['cab_number'] = "$driver_cab";
                     $driver_details['email'] = "$id";
                     
                     echo json_encode($driver_details);
                     exit;
                 


    
} else {
    echo "not getting user information";
}


 
?>