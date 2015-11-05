<?





require_once ('includes/main.inc.php'); 

if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}



$page_header = 'Change Password';





?>





<? include ('top.inc.php'); ?>





<link href="styles.css" rel="stylesheet" type="text/css">





<div id="txtPageHead">Change Password</div>





<div class="msg">The password has been changed successfully </div>





<div class="errorMsg"></div>





<? include ('bottom.inc.php'); ?>