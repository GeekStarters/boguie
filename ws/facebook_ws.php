<?php
include ('../includes/database_connection.php');
$response = array();
$uname = mysql_real_escape_string(addslashes($_REQUEST['email']));
$gcm_regid =$_REQUEST['registro'];
$fullname =$_REQUEST['fullname'];
$facebook_id =$_REQUEST['facebook_id'];
$user_type ='passenger';

if ($uname != "") {
    $ucount = mysql_query("select * from tbl_user where email='$uname'");
    $count = mysql_num_rows($ucount);
    if ($count != 0) {
        $response["success"] = "0";
        $row = mysql_fetch_array($ucount);
        $response["mobile"] = $row["mobile"];
        $response["status"] = $row["status"];

    } else {
        $uinfo = mysql_query("insert into tbl_user (fullname, email, usertype, facebook_id) VALUES ('".$fullname."', '".$uname."', 'passenger', '".$facebook_id."')");
        $response["success"] = "0";
        //$response["success"] = "insert into tbl_user (fullname, email, usertype, facebook_id) VALUES ('".$fullname."', '".$uname."', 'passenger', '".$facebook_id."')";
        $response["mobile"] = "0";
        $response["status"] = $row["status"];

    }

    $sel = mysql_query("SELECT * from gcm_users WHERE email = '$uname'");
    $no_of_rows = mysql_num_rows($sel);
    if ($no_of_rows > 0) {
        mysql_query("UPDATE gcm_users SET gcm_regid='$gcm_regid' WHERE email='$uname'");
    } else {
        mysql_query("INSERT INTO gcm_users(email, gcm_regid, user_type, created_at) VALUES('$uname', '$gcm_regid','$user_type', NOW())");
    }


    echo json_encode($response);
    exit;
}




?>
