<?
require_once("includes/main.inc.php");
    $query="SELECT * from nearest_driver";
    $result=mysql_query($query);
    while($row = mysql_fetch_array($result)){
        $id = $row['id'];
        $title = $row['driver_email'];
        $lapt = $row['latitude'];
        $long = $row['longitude'];
        $status = $row['driver_status'];
        $resultset = mysql_query("SELECT * from tbl_user WHERE email = '$title'");
        $value = mysql_fetch_object($resultset);
        $driver_id = $value->id;
        echo "['<div><h4>$title</h4><br><p>Estado: $status</p><a target=_blank href=view_driver.php?pid=$driver_id>Ver conductor $id</a></div>', $lapt, $long, '$status'],";
    } 
?>