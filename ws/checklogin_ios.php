<?php
include ('../includes/database_connection.php');
$response = array();
$uname = mysql_real_escape_string(addslashes($_REQUEST['username']));
$pass = mysql_real_escape_string(addslashes($_REQUEST['password']));
$gcm_regid =$_REQUEST['registro'];
$user_type =$_REQUEST['user_type'];



if ($uname != "" && $pass != "") {

    $ucount = mysql_query("select * from tbl_user where email='$uname' and password='$pass' and status='Active' ");
    $count = mysql_num_rows($ucount);
    $set = mysql_fetch_object($ucount);

    if ($count == 0) {
        header('Content-type: application/json');
        $response["success"] = 0;
        echo json_encode($response);
        exit;
    } else {

        $uinfo = mysql_query("select * from tbl_user where email='$uname' and password='$pass'  and status='Active' ");
        $res = mysql_fetch_object($uinfo);
        $user_type = $res->usertype;
        $response["success"] = 1;
        $response["user_type"] = $user_type;
        $response["discount"] = $res->discount;
        $response["valid_until"] = $res->valid_until;


        $sel = mysql_query("SELECT * from gcm_users WHERE email = '$uname'");
        $no_of_rows = mysql_num_rows($sel);
        mysql_query("UPDATE gcm_users SET gcm_regid='' WHERE gcm_regid='$gcm_regid'");
        if ($no_of_rows > 0) {
            mysql_query("UPDATE gcm_users SET gcm_regid='$gcm_regid' WHERE email='$uname'");
        } else {
            mysql_query("INSERT INTO gcm_users(email, gcm_regid, user_type, created_at) VALUES('$uname', '$gcm_regid','$user_type', NOW())");
        }


        echo json_encode($response);
        exit;
    }
}

?>