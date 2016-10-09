<?php

include '../includes/database_connection.php';
include '../includes/image_resize_function.php';
$response = array();
//include ('includes/include_files.php');
$base = $_REQUEST['updatepic'];
$user_email = $_REQUEST['email'];
// base64 encoded utf-8 string
$binary = base64_decode($base);
// binary, utf-8 bytes
header('Content-Type: bitmap; charset=utf-8');
// print($binary);
//$theFile = base64_decode($image_data);
$new_image_name = '../profile_pic/image_' . date('Y-m-d-H-i-s') . '.jpg';
$destinationPath = '../profile_pic/image_' . date('Y-m-d-H-i-s') . '_2' . '.jpg';
$img_name = 'image_' . date('Y-m-d-H-i-s') . '_2' . '.jpg';
$file = fopen($new_image_name, 'wb');

fwrite($file, $binary);

fclose($file);

$final_image = createScaledImage($new_image_name, $destinationPath, '150');

$update_img = mysql_query("update tbl_user set image='$img_name' where email='$user_email'");

if ($final_image) {
    $response['success'] = 1;
    echo json_encode($response);
    exit;
} else {
    $response['success'] = 0;
    echo json_encode($response);
    exit;
}
/* $file_path = "profile_pic/";

  $file_path = $file_path . base64_decode( $_FILES['updatepic']['name']);
  if(move_uploaded_file($_FILES['updatepic']['tmp_name'], $file_path)) {
  echo "success";
  } else{
  echo "fail";
  } */
?>