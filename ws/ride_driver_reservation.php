<?php

// response json
$json = array();

/**
 * Store user's lat and long in tbl
 */
if (isset($_REQUEST["id"]) && isset($_REQUEST["lat"]) && isset($_REQUEST["long"]) && isset($_REQUEST["email"])) {
    $driver_details = array();
    $email = $_REQUEST["email"];
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    $ride_id = $_REQUEST["id"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    $db = new DB_Functions();


    $sql_id=mysql_query("Select * from tbl_user where email='".$email."'");
    $row_id= mysql_fetch_array($sql_id);
    $id_driver = $row_id["id"];

    $sql = "select *  from tbl_ride where id='$ride_id'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $status = $row["ride_status"];
    $dateServer = $row["pickup_time"];
    $pickup_address = $row["pickup_address"];
    $latCarrera = $row["latitude"];
    $longCarrera = $row["longitude"];

    $update_status_driver = mysql_query("update nearest_driver set driver_status='booked' where driver_email='".$email."'");
    
    $params = array(
            'origin'        => $lat.','.$long,
            'destination'   => $pickup_address,
            'sensor'        => 'true',
            'units'         => 'imperial'
        );
    foreach($params as $var => $val){
         $params_string .= '&' . $var . '=' . urlencode($val);  
    }
    $url = "http://maps.googleapis.com/maps/api/directions/json?".ltrim($params_string, '&');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($curl);
    curl_close($curl);
    $directions = json_decode($return);
    mysql_query("UPDATE gcm_users SET driver_status='booked' WHERE email='$email'");
    $sel_driver_data = mysql_fetch_object(mysql_query("select * from tbl_user where id='$email'"));
    $driver_email = $sel_driver_data->email;

    $driver_name = $driver_data->fullname;
    $driver_no = $driver_data->mobile;
    $driver_cab = $driver_data->cab_no;
    $distance = $directions->routes[0]->legs[0]->steps[0]->duration->text;
    $eta['reach_time'] = $directions->routes[0]->legs[0]->distance->text;
    
    $passenger_id = $row['passenger'];
    $newSql = "select * from tbl_user,gcm_users where tbl_user.id='$passenger_id' and tbl_user.email=gcm_users.email";

    $newResult = mysql_query($newSql);
    $newRow = mysql_fetch_array($newResult);
    $passenger_email = $newRow["email"];
    $driver_regID= array();
    $driver_regID[] = $newRow['gcm_regid'];     
    
    //$arr = array('response' => 'Carrera confirmada');
    $driver_details['response'] = "Servicio confirmada";


    $message = "$email";
    include_once '../includes/GCM.php';


    $min_distance = "SELECT *, ( 3959 * acos( cos( radians($latCarrera) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($longCarrera) ) + sin( radians($latCarrera) ) * sin( radians( latitude ) ) ) ) "
    . "AS distance FROM nearest_driver HAVING distance < 250 and driver_email='".$email."' ORDER BY distance";

    $min_distance_exe = mysql_query($min_distance);
    $row = mysql_fetch_array($min_distance_exe);

    $distance = round($row['distance'],2);  //distance in miles
    $distance=round($distance*1.60934,2); //distance in kilo
    $avg_speed = 18.64;  // 30kmphr
    $reach_time = round(($distance/$avg_speed)*60 ,2);

    //echo "<br/>";
    $id =$email;
    $driver_info = "select * from tbl_user,tbl_cab where tbl_user.email='$email' and tbl_user.taxi=tbl_cab.id";
    $driver_data = mysql_fetch_object(mysql_query($driver_info));
    $driver_name = $driver_data->fullname;
    $driver_no = $driver_data->mobile;
    $driver_cab = $driver_data->cab_number;
    $image = $driver_data->image;
    $etas=ceil($reach_time);
    $msg ="[$id][$driver_name][$driver_no][$driver_cab][$distance][$etas][$ride_id][$image][$latCarrera][$longCarrera]";


    include_once '../includes/GCM.php';
    $gcm = new GCM();
    $registatoin_ids = $driver_regID;
    $message = array("carrera_confirmada_reservada" => $msg);
    $result = $gcm->send_notification($registatoin_ids, $message);

    $driver_details['distance'] = "$distance";
    $driver_details['reach_time'] = "$etas";
    $driver_details['name'] = "$driver_name";
    $driver_details['number'] = "$driver_no";
    $driver_details['cab_number'] = "$driver_cab";
    $driver_details['email'] = "$id";
    $driver_details['price'] = "$precio_final";
    $driver_details['unique_id'] = "$ride_id";

    echo json_encode($driver_details);
                 
} else {
    echo "not getting user information";
}


 
?>