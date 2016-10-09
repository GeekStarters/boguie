<?php
include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();
$response = array();
if (isset($_REQUEST["d_email"]) && isset($_REQUEST["d_cabtype"]) && isset($_REQUEST["email"]) && isset($_REQUEST["pick_date"]) && isset($_REQUEST["pick_time"]) && isset($_REQUEST["pick_address"]) && isset($_REQUEST["dest_address"]) && isset($_REQUEST["distance"]) && isset($_REQUEST["cab_number"])) {
    
    $driver_email = $_REQUEST["d_email"];
    $dri_cabtype = $_REQUEST["d_cabtype"];
    $user_email = $_REQUEST["email"];
    $pick_date = $_REQUEST["pick_date"];
    $pick_time= $_REQUEST["pick_time"];
    $pick_add = $_REQUEST["pick_address"];
    $dest_add = $_REQUEST["dest_address"];
    $distance = $_REQUEST["distance"];
    $cab_no = $_REQUEST["cab_number"];

     $payment = $_REQUEST["payment"];
    $reference = $_REQUEST["reference"];
    $house = $_REQUEST["house"];
    
    $sel_driver = mysql_fetch_object(mysql_query("select * from tbl_user where email='$driver_email'"));
    $driver_id = $sel_driver->id;
        
    $sel_passenger = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));
    $user_id = $sel_passenger->id;
    $user_name = $sel_passenger->fullname;
    $user_no = $sel_passenger->mobile;
    
    if($dri_cabtype==1){
        $dri_cabtype="3";
    }elseif($dri_cabtype==2){
        $dri_cabtype="1";
    }else{
        $dri_cabtype="2";
    }
    
    $insert_query = "insert into tbl_ride (`driver`,`cab`,`passenger`,`pickup_date`,`pickuptime`,`pickup_address`,`dropoff_address`,`distance`,`cab_number`,`ride_status`, `ride_type`, `payment`, `reference`, `house`)"
            . " values ('$driver_id','$dri_cabtype','$user_id','$pick_date','$pick_time','$pick_add','$dest_add','$distance','$cab_no','pending', 'now', '$payment', '$reference', '$house')";
    
    $insert_exe = mysql_query($insert_query);
    $insert_id = mysql_insert_id();
     if($insert_exe){
        $response['unique_id'] = "$insert_id";
      echo  json_encode($response);
    }
     $driver_regID= array();
  
     $sel_query = mysql_query("SELECT * FROM gcm_users where email='$driver_email' ");
     $row = mysql_fetch_array($sel_query);
         
         $driver_regID[] = $row['gcm_regid'];
     
     
     
    //$regId = $_GET["regId"];
         $newDate = date("M d Y", strtotime($pick_date));
         $time = date("g:i a", strtotime($pick_time));
         
    $msg ="[$user_name][$user_no][$newDate][$time][$pick_add][$dest_add][$insert_id] ";
    
    include_once '../includes/GCM.php';
    
    $gcm = new GCM();

    $registatoin_ids = $driver_regID;
    $message = array("ride_now_confirm_msg" => $msg);

    $result = $gcm->send_notification($registatoin_ids, $message);
    
}
?>