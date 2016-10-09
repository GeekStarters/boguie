<?php
// response json
$json = array();
// Store user details in db
include_once '../includes/db_functions.php';
$db = new DB_Functions();

$sql=mysql_query("SELECT * FROM tbl_content where page_status='Active'");
$details = array();
while ($filas=mysql_fetch_array($sql)) {
  $details[$filas['page_title']] = $filas['page_text'];
}
echo json_encode($details);

?>