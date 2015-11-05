<? require_once("includes/main.inc.php");

$driver_id = $_REQUEST['driver'];
$taxi_id = $_REQUEST['taxi'];

$sql_drivers = "UPDATE tbl_user SET taxi='$taxi_id' WHERE id='$driver_id'";
$result_drivers = mysql_query($sql_drivers);

$sql_taxi = "UPDATE tbl_cab SET with_driver='1' WHERE id='$taxi_id'";
$result_taxi = mysql_query($sql_taxi);

?>
