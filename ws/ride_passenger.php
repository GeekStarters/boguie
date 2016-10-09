<?php
date_default_timezone_set('America/Mexico_City');
include_once '../includes/db_functions.php';
    
$db = new DB_Functions();
$response = array();
$response['unique_id']="vacio";
$exist_taxis=0;
$drivers= array();

if (isset($_REQUEST["email"]) && isset($_REQUEST["pick_date"]) && isset($_REQUEST["pick_time"]) && isset($_REQUEST["pick_address"])) {
    $user_email = $_REQUEST["email"];
    $pick_date = $_REQUEST["pick_date"];
    $pick_time= $_REQUEST["pick_time"];
    $pick_add = $_REQUEST["pick_address"];
    $dest_add = $_REQUEST["dest_address"];
    $payment = $_REQUEST["payment"];
    $reference = $_REQUEST["reference"];
    $house = $_REQUEST["house"];
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    $cab_type = $_REQUEST["cabtype"];
    $discount = $_REQUEST["discount"];
    $distance= $_REQUEST["distance"];
    $dropoff_address = $_REQUEST["dropoff_address"];
    $latitude_destino = $_REQUEST["latitude_destino"];
    $longitude_destino = $_REQUEST["longitude_destino"];

    $info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];
    $current_date = "$year-$month-$date $hour:$min:$sec";

    //id usuario
    $sql_id=mysql_query("Select * from tbl_user where email='".$user_email."'");
    $row_id = mysql_fetch_array($sql_id);
    $user_id = $row_id["id"];
    $status=$row_id["status"];

    if($status=="Active"){
        


        
        //INSERT NEW RIDE
        $insert_query = "insert into tbl_ride (`passenger`,`pickup_date`,`pickup_time`,`pickuptime`,`pickup_address`,`dropoff_address`,`ride_status`, `ride_type`, `payment`, `reference`, `house`, `discount`, `latitude`, `longitude`,`latitude_destino`,`longitude_destino`,`distance`)"
                . " values ('$user_id','$pick_date','$current_date','$pick_time','$pick_add','$dropoff_address','pending', 'now', '$payment', '$reference', '$house', '$discount','$lat','$long','$latitude_destino','$longitude_destino','$distance')";
        $insert_exe = mysql_query($insert_query);
        $insert_id = mysql_insert_id();
        ///Consultar conductores cercanos
        $res = $db->updatePos($email, $lat, $long, $cab_type);  
        mysql_query("SELECT SLEEP(5)");
            $p_cab_type = $_REQUEST["cabtype"];
            if($p_cab_type == 1){
                $p_cab_type = 7;
            }else if($p_cab_type == 2){
                $p_cab_type = 8;
            }else{
                $p_cab_type = 9;
            }

       

        $min_distance = mysql_query("SELECT ( 3959 * acos( cos( radians($lat) ) * cos( radians( nearest_driver.latitude ) ) * cos( radians( nearest_driver.longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( nearest_driver.latitude ) ) ) ) "
            . "AS distance,nearest_driver.id,nearest_driver.user_email,nearest_driver.latitude,nearest_driver.longitude,nearest_driver.cab_type,nearest_driver.driver_status,nearest_driver.updated_on,nearest_driver.updated_on,tbl_user.status,nearest_driver.driver_email,tbl_user.email FROM nearest_driver,tbl_user HAVING distance < 19 and driver_status = 'available' and nearest_driver.driver_email=tbl_user.email and tbl_user.status='Active' ORDER BY distance LIMIT 15");


        //echo "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
          // . "AS distance FROM nearest_driver HAVING distance < 250 and driver_status = 'available' ORDER BY distance";

        /// Enviar push a cada usuario cercano y regresar resultados
        
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
            //echo "<br>";
            $current_date = "$year-$month-$date $hour:$min:$sec";
            $timeFirst  = strtotime($ultima_fecha);
            $timeSecond = strtotime($current_date);
            $differenceInSeconds = $timeSecond - $timeFirst;
            if($differenceInSeconds<1800){
                $exist_taxis=1;
                $sql_gcm=mysql_query("Select * from gcm_users where email='".$row['driver_email']."' and user_type='driver' and driver_status='available' and gcm_regid!=''");
                while ($fila=mysql_fetch_array($sql_gcm)) {
                    $driver_regID[] = $fila['gcm_regid'];
                    $driver_gcm=$fila['gcm_regid'];
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

                $sql_user=mysql_query("Select * from tbl_user where email='".$user_email."' LIMIT 1");
                while ($fila_user=mysql_fetch_array($sql_user)) {
                    $user_name= $fila_user['fullname'];
                    $user_no= $fila_user['mobile'];
                    //echo $fila['gcm_regid'];
                }

                $hora_actual=date('H:i:s');  
                $hora1 =  strtotime($hora_actual);
                $total=0;
                $sqlTarifa="SELECT * FROM tarifas WHERE $distance BETWEEN desde AND hasta LIMIT 1";
                $queryTarifa=mysql_query($sqlTarifa);
                while($filasTarifa=mysql_fetch_array($queryTarifa)){
                    $hora2 =  strtotime($filasTarifa['horario_nocturno_desde']);
                    $hora3 =  strtotime($filasTarifa['horario_nocturno_hasta']);
                    if($hora1>=$hora2){
                        $total=$filasTarifa['costo']+$filasTarifa['factor_app']+$filasTarifa['factor_nocturno'];
                    }elseif($hora1<=$hora3){
                        $total=$filasTarifa['costo']+$filasTarifa['factor_app']+$filasTarifa['factor_nocturno'];
                    }else{
                        $total=$filasTarifa['costo']+$filasTarifa['factor_app'];
                    }
                }

                
                
                $newDate = date("M d Y", strtotime($pick_date));
                $time = date("g:i a", strtotime($pick_time));
                $msg ="[$user_name][$user_no][$newDate][$time][$pick_add][$dest_add][$insert_id][$discount][$reference][$house][$lat][$long][$distance][$dropoff_address][$latitude_destino][$longitude_destino][$total]";
                $driver['latitude'] = $row['latitude'];
                $driver['longitude'] = $row['longitude'];
                $driver['email'] = $row['driver_email'];
                $driver['id_carrera'] = "$insert_id";
                array_push($drivers, $driver);
            }
        }
      // [][][Jul 18 2015][8:04 pm][Pje 9, Apopa, El Salvador][][122] 

        //envio de push
        if($exist_taxis==1){
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $driver_regID;
            $message = array("ride_now_confirm_msg" => $msg);
            $result = $gcm->send_notification($registatoin_ids, $message);   
        }
        
        //echo json_encode($drivers);
        $response['unique_id']="$insert_id";
        echo  json_encode($response); 
    }else{
        $response['unique_id']=$status;
        echo  json_encode($response); 
    }
    //echo $insert_query;
}
?>