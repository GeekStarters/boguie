<?php
include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();
$response = array();
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


    //id usuario
    $sql_id=mysql_query("Select * from tbl_user where email='".$user_email."'");
    $row_id = mysql_fetch_array($sql_id);
    $user_id = $row_id["id"];
    
    //INSERT NEW RIDE
    $insert_query = "insert into tbl_ride (`passenger`,`pickup_date`,`pickuptime`,`pickup_address`,`dropoff_address`,`ride_status`, `ride_type`, `payment`, `reference`, `house`, `discount`)"
            . " values ('$user_id','$pick_date','$pick_time','$pick_add','$dest_add','pending', 'now', '$payment', '$reference', '$house', '$discount')";
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

    $min_distance = mysql_query("SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
        . "AS distance FROM nearest_driver HAVING distance < 250 and driver_status = 'available' ORDER BY distance");

   //echo ("SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
     //   . "AS distance FROM nearest_driver HAVING distance < 250 and driver_status = 'available' ORDER BY distance");


    /// Enviar push a cada usuario cercano y regresar resultados
    $drivers= array();
    $driver_regID= array();
    $count=@mysql_num_rows($min_distance);

    while ($row = mysql_fetch_array($min_distance)) {
       $driver= array();
        
      
        //obtener gcm_users
       // echo "Select * from gcm_users where email='".$row['driver_email']."' and user_type='driver' and driver_status='available'";
        //echo "<br>";
        echo ("Select * from gcm_users where email='".$row['driver_email']."' and user_type='driver' and driver_status='available' and gcm_regid!=''");
        echo "<br>";
       $sql_gcm=mysql_query("Select * from gcm_users where email='".$row['driver_email']."' and user_type='driver' and driver_status='available' and gcm_regid!=''");
        while ($fila=mysql_fetch_array($sql_gcm)) {
            $driver_regID[] = $fila['gcm_regid'];
            echo "sii";
        }

        $sql_user=mysql_query("Select * from tbl_user where email='".$user_email."' LIMIT 1");
        while ($fila_user=mysql_fetch_array($sql_user)) {
            $user_name= $fila_user['fullname'];
            $user_no= $fila_user['mobile'];
            //echo $fila['gcm_regid'];
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

  // [][][Jul 18 2015][8:04 pm][Pje 9, Apopa, El Salvador][][122] 

    //envio de push
    include_once '../includes/GCM.php';
    $gcm = new GCM();
    $registatoin_ids = $driver_regID;
    $message = array("ride_now_confirm_msg" => $msg);
    foreach ($driver_regID as &$valor) {
       echo "Valor: $valor<br />";
    }
    //echo $result = $gcm->send_notification($registatoin_ids, $message);

    //echo json_encode($drivers);
}
?>