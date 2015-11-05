<?php


require_once('includes/main.inc.php');


if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}


$res1=mysql_fetch_array(db_query("select * from tbl_member_doc where slno='$_REQUEST[slno]'"));


echo mysql_error();


@extract($res1);





$dir= UP_FILES_FS_PATH."/member_document/";


$file=$member_document;





header('Content-Description: File Transfer');


header('Content-Type: application/octet-stream');


header('Content-Disposition: attachment; filename='.basename($file));


header('Content-Transfer-Encoding: binary');


header('Expires: 0');


header('Cache-Control: must-revalidate, post-check=0, pre-check=0');


header('Pragma: public');


header('Content-Length: ' . filesize($dir."/".$file));


ob_clean();


flush();


readfile("$dir/$file");


exit;


?>