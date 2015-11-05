<?php
require_once("/var/www/html/geotaxi/includes/main.inc.php");
$fecha = new DateTime('now', new DateTimeZone('America/Cancun'));
$today = $fecha->format('Y-m-d');
//$today_hora = $fecha->format('h:i:s');
//print_r($today_hora);
//print_r($today);
db_query("UPDATE `tbl_coupon` SET `status` = '0' WHERE `tbl_coupon`.`add_date` = '".$today."';") or die(mysql_error());
//$sql = "insert into tbl_coupon set coupon='".$today_hora."', flat_discount='88.99', add_date='".$today."', status=0";
//$result = mysql_query($sql);
//print_r($sql);
//print_r($result);
//exit();