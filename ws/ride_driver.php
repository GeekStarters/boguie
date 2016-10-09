<?php
date_default_timezone_set('America/Mexico_City');
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
    $info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];
    $current_date = "$year-$month-$date $hour:$min:$sec";
    $timeFirst  = strtotime($dateServer);
    $timeSecond = strtotime($current_date);
    $differenceInSeconds = $timeSecond - $timeFirst;

    if ($status == 'pending') {
        //echo $differenceInSeconds;

        if($differenceInSeconds<3000){

            $update = mysql_query("update tbl_ride set ride_status='confirm',driver='".$id_driver."' where id='".$ride_id."'");
            $update_status_driver = mysql_query("update nearest_driver set driver_status='booked' where driver_email='".$email."'");
            $pickup_address = $row["pickup_address"];
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
            $newSql = "select *  from tbl_user where id='$passenger_id'";
            $newResult = mysql_query($newSql);
            $newRow = mysql_fetch_array($newResult);
            $passenger_email = $newRow["email"];
            $driver_regID= array();
            $sel_query = mysql_query("SELECT * FROM gcm_users where email='$passenger_email'");
            $row = mysql_fetch_array($sel_query);
            $driver_regID[] = $row['gcm_regid'];     
          
            //$arr = array('response' => 'Carrera confirmada');
            $driver_details['response'] = "Servicio confirmado";


            $message = "$email";
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
            . "AS distance FROM nearest_driver HAVING distance < 250 and driver_status = 'available' ORDER BY distance";

            $min_distance_exe = mysql_query($min_distance);
            $row = mysql_fetch_array($min_distance_exe);
                
            $id = $row['driver_email'];


            $precio=mysql_query("Select * from tbl_user,tbl_cab where tbl_user.email='".$id."' and tbl_user.taxi=tbl_cab.id");
            $row_precio= mysql_fetch_array($precio);
            $precio_final=$row_precio['fare_per_km'];

            $distance = round($row['distance'],2);  //distance in miles
            $avg_speed = 18.64;  // 30kmphr
            $reach_time = round(($distance/$avg_speed)*60 ,2);

            //echo "<br/>";
            $driver_info = "select * from tbl_user,tbl_cab where tbl_user.email='$email' and tbl_user.taxi=tbl_cab.id";
            $driver_data = mysql_fetch_object(mysql_query($driver_info));
            $driver_name = $driver_data->fullname;
            $driver_no = $driver_data->mobile;
            $driver_cab = $driver_data->cab_number;
            $image = $driver_data->image;
            $eta=$distance*1.86;
            $msg ="[$id][$driver_name][$driver_no][$driver_cab][$distance][$eta][$ride_id][$image]";


            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $driver_regID;
            $message = array("carrera_confirmada" => $msg);
            $result = $gcm->send_notification($registatoin_ids, $message);
      
            $driver_details['distance'] = "$distance";
            $driver_details['reach_time'] = "$reach_time";
            $driver_details['name'] = "$driver_name";
            $driver_details['number'] = "$driver_no";
            $driver_details['cab_number'] = "$driver_cab";
            $driver_details['email'] = "$id";
            $driver_details['price'] = "$precio_final";
            $driver_details['unique_id'] = "$ride_id";

        }else{
            $driver_details['response'] = "Este servicio ya fue atendido";
        }

        echo json_encode($driver_details);

    }else{
        //$arr = array('response' => 'Este servicio ya fue atendido');
        $driver_details['response'] = "Este servicio ya fue atendido";
        echo json_encode($driver_details);
    }

    exit;
                 
} else {
    echo "not getting user information";
}


 
?>