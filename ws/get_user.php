<?php
// response json
    $json = array();
    $email_user = $_REQUEST["email"];
    include_once '../includes/db_functions.php';
    $db = new DB_Functions();
    $sql="SELECT * FROM tbl_user WHERE email='$email_user' LIMIT 1";
    $query=mysql_query($sql);
    while ($row = mysql_fetch_array($query)) {
        $json['id'] = $row['id'];
        $json['fullname'] = $row['fullname'];
        $json['email'] = $row['email'];
        $json['birthday'] = $row['birthday'];
        $json['mobile'] = $row['mobile'];
        $json['strikes'] = $row['strikes'];
        $json['discount'] = $row['discount'];
        $json['valid_until'] = $row['valid_until'];
    }

    echo $objectBannerJSON = json_encode($json);
?>

