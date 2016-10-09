<?php
$json = array();
include_once '../includes/db_functions.php';
$db = new DB_Functions();
if (isset($_REQUEST["id"])){
    $ride_id = $_REQUEST["id"];
    $sql = "select *  from tbl_ride where id='$ride_id'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $status = $row["ride_status"];
    $dateServer = $row["pickup_time"];
    $driver_id = $row["driver"];
    $lat = $_REQUEST["lat"];
    $long = $_REQUEST["long"];

    if ($driver_id=='0'){
        $driver_details['response'] = "ninguno";
    }else{
            
        $sqlEmail=mysql_query("SELECT * FROM tbl_user WHERE id='".$driver_id."'");
        $rowEmail= mysql_fetch_array($sqlEmail);
        $statusEmail = $rowEmail["email"];


        $min_distance = "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) "
            . "AS distance FROM nearest_driver HAVING distance < 250 and driver_email='".$statusEmail."' ORDER BY distance";
        
        $min_distance_exe = mysql_query($min_distance);
        $row_distance= mysql_fetch_array($min_distance_exe);

        $distance = round($row_distance['distance'],2);  //distance in miles
        $avg_speed = 18.64;  // 30kmphr
        $reach_time = round(($distance/$avg_speed)*60 ,2);


        $driver_details['response'] = "con taxista";
        $driver_info = "select * from tbl_user,tbl_cab where tbl_user.email='".$statusEmail."' and tbl_user.taxi=tbl_cab.id";
        $driver_data = mysql_fetch_object(mysql_query($driver_info));
        $driver_name = $driver_data->fullname;
        $driver_no = $driver_data->mobile;
        $driver_cab = $driver_data->cab_number;
        $image = $driver_data->image;
        $eta=$distance*1.86;
        $driver_details['id'] = $statusEmail;
        $driver_details['driver_name'] = $driver_name;
        $driver_details['driver_no'] = $driver_no;
        $driver_details['driver_cab'] = $driver_cab;
        $driver_details['distance'] = $distance;
        $driver_details['eta'] = $eta;
        $driver_details['ride_id'] = $ride_id;
        $driver_details['image'] = $image;
    }

    echo json_encode($driver_details);
}

?>