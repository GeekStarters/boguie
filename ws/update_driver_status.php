<?php
if (isset($_REQUEST["email"]) && isset($_REQUEST["driver_status"])) {
    
    $email = $_REQUEST["email"];
    $status = $_REQUEST["driver_status"];
    
    include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();

    $res = $db->updateDriverStatus($email, $status);  
    
    $response = array();
    if($res){
        $response['success'] = 1;
      echo  json_encode($response);
    }else{
        $response['success'] = 0;
     echo   json_encode($response);
    }
    
    
}else{
    
    echo "not getting information";
}



?>