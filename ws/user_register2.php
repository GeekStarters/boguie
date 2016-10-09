<?php
include ('../includes/include_files_app.php');
$msg = "";


$date = date('Y-m-d');

$full_name = mysql_real_escape_string(addslashes($_REQUEST['fname']));
$email_address = mysql_real_escape_string(addslashes($_REQUEST['email']));
$pass = mysql_real_escape_string(addslashes($_REQUEST['password']));
$contact_no = mysql_real_escape_string(addslashes($_REQUEST['mobile']));
$usertype = "passenger";
$type_count = mysql_real_escape_string(addslashes($_REQUEST['type_count']));
$type_count = mysql_real_escape_string(addslashes($_REQUEST['type_count']));
$facebook_id = mysql_real_escape_string(addslashes($_REQUEST['facebook_id']));
$birthday = mysql_real_escape_string(addslashes($_REQUEST['birthday']));
$status="Active";

if ($full_name != "" && $email_address != "" && $pass != "" && $contact_no != "" && $usertype != "" && $type_count != "") {
    $checkinfo = mysql_query("select * from tbl_user where email='" . $email_address . "' ");
    $count_email = mysql_num_rows($checkinfo);
    if ($count_email == 0) {

        $reg_ins = mysql_query("insert into tbl_user(`fullname`, `email`, `birthday`, `password`, `mobile`, `usertype`,`add_date`, `status`, `type_count`, `facebook_id` ) values ('$full_name','$email_address','$birthday','$pass','$contact_no','$usertype','$date', '$status', '$type_count', '$facebook_id')");

        if ($reg_ins) {

            $uinfo = mysql_query("select * from tbl_user where email='" . $_POST['email'] . "' and password='" . $_POST['password'] . "' ");
            $res = mysql_fetch_object($uinfo);
            $ultimoid=mysql_insert_id();
            $response = array("msg" => "Usuario registrado", "success" => 1, "id_user" => $ultimoid);
        }
    } else {
        $response = array("msg" => "Email ya existe", "success" => 0);
    }
} else {
    $response = array("msg" => "Error en el envio de datos", "success" => 0);
}
$gcm_regid =$_REQUEST['registro'];
if($gcm_regid!=""){

        $sel = mysql_query("SELECT * from gcm_users WHERE email = '$email_address'");
        $no_of_rows = mysql_num_rows($sel);
        mysql_query("UPDATE gcm_users SET gcm_regid='' WHERE gcm_regid='$gcm_regid'");
        if ($no_of_rows > 0) {
            mysql_query("UPDATE gcm_users SET gcm_regid='$gcm_regid' WHERE email='$email_address'");
        } else {
            mysql_query("INSERT INTO gcm_users(email, gcm_regid, user_type, created_at) VALUES('$email_address', '$gcm_regid','passenger', NOW())");
        }
}

$final_res =json_encode($response) ;
echo $final_res;

?>