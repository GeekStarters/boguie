<?php
include ('../includes/include_files.php');

$email_address = mysql_real_escape_string(addslashes($_REQUEST['email']));

    if ($email_address != "") {

        $checkinfo = mysql_query("select * from tbl_user where email='" . $email_address . "' ");
        $count_email = mysql_num_rows($checkinfo);
        if ($count_email != 0) {

            $res = mysql_fetch_object($checkinfo);
            $passwd = $res->password;

            $to = "$email_address";
            $subject = "Your Password For Cab Book Now App";

            $message = "<html><head><title>Your Password For GeoTaxi</title></head><body><table><tr><td>User Name:</td><td>$email_address</td></tr><tr><td>Password:</td><td>$passwd</td></tr></table></body></html>";

// Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
            $headers .= 'From:GeoTaxi<' . $admin_mail . ">\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

            $mail = mail($to, $subject, $message, $headers);

            if ($mail) {
                $msg = "Please Check Your Email For Password.";
            }
        } else {

            $msg = " Email ID Doesn't Exist.";
        }
    } else {

        $msg = "Please Enter Email ID";
    }

$response["msg"] = $msg;
echo json_encode($response);
exit;
?>