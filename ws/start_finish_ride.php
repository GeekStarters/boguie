<?php
    include_once '../includes/db_functions.php';
    $precio="5";

    $db = new DB_Functions();
    if (isset($_REQUEST["unique_id"]) && isset($_REQUEST["start_finish"])) {
        $unique_id = $_REQUEST["unique_id"];
        $start_finish = $_REQUEST["start_finish"];
        $latitude = $_REQUEST["latitude"];
        $longitude = $_REQUEST["longitude"];
        $latlong = $latitude."&".$longitude;

        if ($start_finish == "start") {
            $update_status = "update tbl_ride set start_time=now(), start_geo='$latlong' where id='$unique_id' ";
            $update_status_exe = mysql_query($update_status);
            $arr = array('response' => 'Enjoy your ride');
            echo json_encode($arr);
            //enviar push
            $sql=mysql_query("Select * from tbl_ride,tbl_user,gcm_users where tbl_ride.id='$unique_id' and tbl_ride.passenger=tbl_user.id and tbl_user.email=gcm_users.email");
            $row_id = mysql_fetch_array($sql);
            $driver_regID[]  = $row_id["gcm_regid"];
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $driver_regID;
            $message = array("empezar_carrera" => "Ud a abordado su taxi");
            $result = $gcm->send_notification($registatoin_ids, $message);

        }elseif ($start_finish == "finish") {
            $update_status = "update tbl_ride set dropoff_time=now(), finish_geo='$latlong' where id='$unique_id' ";
            $update_status_exe = mysql_query($update_status);

            $update_status_driver = mysql_query("update nearest_driver set driver_status='available' where driver_email='".$email."'");

            $sql = "select *  from tbl_ride where id='$unique_id'";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $driver = $row["driver"];
            $passenger = $row["passenger"];
            $discount = $row["discount"];
            $startingPoint = $row["start_geo"];


            //enviar push
            $sql=mysql_query("Select * from tbl_ride,tbl_user,gcm_users where tbl_ride.id='$unique_id' and tbl_ride.passenger=tbl_user.id and tbl_user.email=gcm_users.email");
            $row_id = mysql_fetch_array($sql);
            $driver_regID[]  = $row_id["gcm_regid"];
            $id_taxista=$row_id['driver'];

            //obtener correo taxista
            $sql_t=mysql_query("SELECT * FROM  tbl_user where id='".$id_taxista."'");
            $row_t = mysql_fetch_array($sql_t);
            $email_taxista=$row_t['email'];

            $update = mysql_query("update nearest_driver set driver_status='available' where driver_email='".$email_taxista."'");

            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $driver_regID;
            $msg ="[$unique_id][$unique_id]";
            $message = array("finalizar_carrera" => $msg);
            $result = $gcm->send_notification($registatoin_ids, $message);

            //pasar a disponible es estado del taxista
            $sql_id=mysql_query("Select * from tbl_user where id='".$driver."'");
            $row_id = mysql_fetch_array($sql_id);
            $email_driver = $row_id["email"];
            mysql_query("UPDATE gcm_users SET driver_status='available' WHERE email='$email_driver'");


            $sql_d = "select *  from tbl_user where id='$driver'";
            $result_d = mysql_query($sql_d);
            $row_d = mysql_fetch_array($result_d);
            $driverEmail = $row_d["email"];

            $update_status_driver = mysql_query("update nearest_driver set driver_status='avaliable' where email='".$driverEmail."'");
            $arr = array('response' => 'done');


            //obtener precio


            //calcular distancia
            $sql_distancia=mysql_query("Select * from tbl_ride where id='$unique_id'");
            $row_distancia = mysql_fetch_array($sql_distancia);

            $start_geo = explode("&", $row_distancia['start_geo']);
            $lat1=$start_geo[0];
            $lon1=$start_geo[1];


            $finish_geo = explode("&", $row_distancia['finish_geo']);
            $lat2=$finish_geo[0];
            $lon2=$finish_geo[1];

            $dropoff_time=$row_distancia['dropoff_time'];
            $start_time=$row_distancia['start_time'];

            $kilometros=distance($lat1,$lon1,$lat2,$lon2,"K");
            $precio=$kilometros*$precio;
    
            $start_date = new DateTime($start_time);
            $since_start = $start_date->diff(new DateTime($dropoff_time));
            ;

            $arr = array('response' => 'done','time' => $since_start->i.' minutos','distance' => $kilometros,'precio' => $precio."");


            echo json_encode($arr);

            if ($discount > 0) {
               $update_status_driver = mysql_query("update tbl_user set discount = 0, points = 0 where email='".$passenger."'");
            }
            
            $start_from_db = explode("&", $startingPoint);
            $distance = distance($start_from_db[0], $start_from_db[1], $latitude, $longitude, "K");
            
            $getDriverID = "select *  from tbl_user where email='$email_taxista'";
            $driverData = mysql_query($getDriverID);
            $driverRow = mysql_fetch_array($driverData);
            $driverTaxi = $driverRow["taxi"];

            $getTaxi = "select * from tbl_cab where id='$driverTaxi'";
            $taxiData = mysql_query($getTaxi);
            $taxiRow = mysql_fetch_array($taxiData);
            $fare = $taxiRow["fare_per_km"];
            $cab_number = $taxiRow["cab_number"];

            $calculated_fare_discount = $distance * $fare - $discount;
            $calculated_fare = $distance * $fare;

            $insert = mysql_query("INSERT INTO tbl_payments (amount, transaction_id, passenger_id, driver_id, distance, cab_number, status, without_discount, discount) VALUES ('$calculated_fare_discount', '$unique_id', '$passenger', '$driver', '$distance', '$cab_number', 'pending', '$calculated_fare', '$discount')");

        }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if($unit == "K") {
            $dis=$miles * 1.609344;
            return number_format((float)$dis, 2, '.', '');
        }else if($unit == "N") {
            return ($miles * 0.8684);
        }else {
            return $miles;
        }
    }
?>