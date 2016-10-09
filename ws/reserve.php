<?php
include_once '../includes/db_functions.php';

function limpiarCaracteresEspeciales($string ){
 $string = htmlentities($string);
 $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
 return $string;
}

$db = new DB_Functions();
$response = array();
if (isset($_REQUEST["email"]) && isset($_REQUEST["pick_date"]) && isset($_REQUEST["pick_time"]) && isset($_REQUEST["pick_address"])) {
    $user_email = $_REQUEST["email"];
    $pick_date = $_REQUEST["pick_date"];
    $pick_time= $_REQUEST["pick_time"];
    $pick_add = limpiarCaracteresEspeciales($_REQUEST["pick_address"]);
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];
    $payment = $_REQUEST["payment"];
    $reference = limpiarCaracteresEspeciales($_REQUEST["reference"]);
    $house = limpiarCaracteresEspeciales($_REQUEST["house"]);

    //Optionals
    $dest_add = $_REQUEST["dest_address"];
    $distance = $_REQUEST["distance"];
    $discount = $_REQUEST["discount"];


    $dropoff_address = $_REQUEST["dropoff_address"];
    $latitude_destino = $_REQUEST["latitude_destino"];
    $longitude_destino = $_REQUEST["longitude_destino"];

    
   // echo "select * from tbl_user where email='$user_email'";
    $sel_passenger = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));
    $user_id = $sel_passenger->id;
    $user_name = $sel_passenger->fullname;
    $user_no = $sel_passenger->mobile;
    $status=$sel_passenger->status;

    if($status=="Active"){

        $insert_query = "insert into tbl_ride (`passenger`,`pickup_date`,`pickuptime`,`pickup_address`,`dropoff_address`,`distance`,`ride_status`, `ride_type`, `payment`, `reference`, `house`, `discount`, `latitude`, `longitude`,`latitude_destino`,`longitude_destino`)"
                . " values ('$user_id','$pick_date','$pick_time','$pick_add', '$dropoff_address', '$distance', 'pending', 'reservation', '$payment', '$reference', '$house', '$discount','$lat','$long','$latitude_destino','$longitude_destino')";
        
        $insert_exe = mysql_query($insert_query);
        $insert_id = mysql_insert_id();
        if($insert_exe){
            $response['unique_id'] = "$insert_id";
            echo  json_encode($response);
        }else{
            $response['unique_id'] = "Error";
            //$response['unique_id'] =$insert_query;
            echo  json_encode($response);
        }

    }else{
        $response['unique_id']=$status;
        echo  json_encode($response);
    }
    
}
?>