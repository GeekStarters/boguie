<?php
include_once '../includes/db_functions.php';
$db = new DB_Functions();
$response = array();
if (isset($_REQUEST["email"]) && isset($_REQUEST["id"])) {
    $user_email = $_REQUEST["email"];
    $id = $_REQUEST["id"];
    $delete = "DELETE FROM tbl_address WHERE id_address='$id' AND email_user='$user_email'";
    $delete_exe = mysql_query($delete);
    if($delete_exe){
        $response['success'] = "true";
        echo  json_encode($response);
    }else{
        $response['success'] = "false";
        echo  json_encode($response);
    }
}
?>