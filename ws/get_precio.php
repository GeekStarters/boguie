<?php
// response json
$json = array();
// Store user details in db
include_once '../includes/db_functions.php';
$db = new DB_Functions();

$sql="SELECT * FROM tbl_cab WHERE category='7'";

$sql_direccion=mysql_query($sql);
$driver_details = array();
while ($filas=mysql_fetch_array($sql_direccion)) {
  $driver_details['precio'] = $filas['fare_per_km'];  
}
echo json_encode($driver_details);
?>