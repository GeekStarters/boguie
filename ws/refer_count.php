<?php
define("MAX_REFER",20);
//include ('../includes/constant.php');
include ('../includes/database_connection.php');
$response = array();
if($_REQUEST['email'] && $_REQUEST['count'] && $_REQUEST['friends_ids']){
    
    $email = $_REQUEST['email'];
    $count = $_REQUEST['count'];
    $friends_ids = $_REQUEST['friends_ids'];
    $friends = trim(str_replace(array('[',']'),'',$friends_ids));
    $friends2 = explode(",",$friends);
    
    //echo "<pre>";print_r($friends);exit;
    
    $sel = mysql_query("select * from refer_friend where email='$email'");
    $sel_data = mysql_fetch_object($sel);
   $num_count = mysql_num_rows($sel);
   if($num_count > 0){
       $friends_ids2 = $sel_data->friend_ids;
       $friends_ids2 = explode(",",$friends_ids2);
       $output = array_unique(array_merge($friends_ids2, $friends2));
       $output_count = count(array_unique(array_merge($friends_ids2, $friends2)));
       $output = implode(",",$output);
      //echo "<pre>"; print_r($output);exit;
       $update_refer = mysql_query("update refer_friend set count='$output_count' , friend_ids='$output' where email='$email' and valid_flag='0' ");
       if($update_refer){         
           
           if($output_count >= 20){
              $update_flag = mysql_query("update refer_friend set valid_flag ='1' where email='$email' "); 
              $response['success']= 2;
              $response['couponcode']= 1;
               echo json_encode($response);
                $sel_coupon = mysql_fetch_object(mysql_query("select * from tbl_coupon where status = 1 limit 1"));
               $coupon = $sel_coupon->coupon;
               
               $to = "$email";
$subject = "Your Coupon Code From Book My Cab";

$message = "
<html>
<body>
<p>You have successfully refer 20 friends and got a Coupon Code \"$coupon\".Now You can use this coupon in Your Next Ride.</p>
    <p>Thanks , Book My Cab</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Book My Cab' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);
           }else{
               $response['success']= 1;
           $response['count']= 20-$output_count;
               echo json_encode($response);
           }
       }else{
           $response['success']= 0;
               echo json_encode($response);
       }
   }else{
       $sel = mysql_query("insert into refer_friend set count='$count' , friend_ids='$friends' , email='$email'");
       if($count >= 20){
              $update_flag = mysql_query("update refer_friend set valid_flag ='1' where email='$email' "); 
              $response['success']= 2;
              $response['couponcode']= 1;
               echo json_encode($response);
               $sel_coupon = mysql_fetch_object(mysql_query("select * from tbl_coupon where status = 1 limit 1"));
               $coupon = $sel_coupon->coupon;
               
               $to = "$email";
$subject = "Your Coupon Code From Book My Cab";

$message = "
<html>
<body>
<p>You have successfully refer 20 friends and got a Coupon Code \"$coupon\".Now You can use this coupon in Your Next Ride.</p>
    <p>Thanks , Book My Cab</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Book My Cab' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);
               
           }else{
               $response['success']= 1;
           $response['count']= 20-$count;
               echo json_encode($response);
           }
   }
   
}


?>