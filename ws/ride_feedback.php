<?php
	include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();
	$response = array();
	if (isset($_REQUEST["id"])) {
	    $ride_id = $_REQUEST["id"];
	    $points = $_REQUEST["points"];
	    $comments = $_REQUEST["comments"];

		$sql = "UPDATE tbl_ride SET points='$points', comments='$comments' WHERE id = $ride_id";
		$retval = mysql_query($sql);
		if(! $retval )
		{
		  $response['result'] = $row["Ok"];
		}else{
		$response['result'] = $row["Error"];
		}
		echo  json_encode($response);
	}
?>