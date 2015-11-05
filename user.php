<? include_once("includes/main.inc.php");

if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}

if(is_post_back()) {

if($nu_id!=''){

$check		=	checkAvailableRecord('tbl_newsletter',"count(*)"," nu_email='$nu_email'  And nu_id!='$nu_id' ");

if($check=="" or $check==0){

$sql = "Update tbl_newsletter set nu_name='$nu_name', nu_email='$nu_email'  where nu_id = $nu_id";

db_query($sql);

set_session_msg("Newsletter user has been updated successfully.");

header("Location: newsletter.php?start=$start");

exit;

}else{			

set_session_msg("This newsletter user already exist.");

}

}else{

$check				=	checkAvailableRecord('tbl_newsletter','nu_id',"nu_email='$nu_email'  And nu_status!='Inactive'" );

if($check=="" or $check==0)		{

$date_arr=explode('-',MYSQL_DATE);

$sql 		= "Insert into tbl_newsletter set nu_name='$nu_name',nu_status='active', nu_email='$nu_email',nu_date='".MYSQL_DATE."' ";

db_query($sql);

set_session_msg("Newsletter User has been added successfully.");

header("Location: newsletter.php?start=$start");

exit;

}else{

set_session_msg("This newsletter user already exist.");

}			

}

}



if($_REQUEST['nu_id']!='' && $_REQUEST['nu_id']!='0'){

$query	=	db_query("select * from tbl_newsletter where nu_id='$nu_id'");

if(mysql_num_rows($query)>0){

$row=mysql_fetch_array($query);

@extract($row);

}

}



?>

<script type="text/javascript" src="../js/validation.js"></script>

<link href="styles.css" rel="stylesheet" type="text/css">

<? include("top.inc.php");?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td id="pageHead"><div id="txtPageHead">Add/Edit Newsletter User </div></td>

</tr>

</table>

<div align="center"  class="msg"><strong><?=display_sess_msg();?></strong></div>

<br />

<form name="form2" action=""  method="post" onsubmit="return validate(this)">

<table width="300" align="center" border="0" cellspacing="0" cellpadding="0" class="tableSearch">      

<tr>

<td height="14" colspan="2">&nbsp;</td>

</tr>	 

<tr>

<td width="115" height="14" align="left">&nbsp;<strong>Name*</strong></td>

<td width="224" height="14" align="left"><input type="text" name="nu_name"  value="<?=$nu_name?>" id="NOBLANK~Please Enter Name~DM~"/></td>

</tr>

<tr>

<td height="14" align="left">&nbsp;<strong>Email*</strong></td>

<td height="14" align="left"><input type="text" name="nu_email"  value="<?=$nu_email?>" id="NOBLANK~Please Enter Email~DM~EMAIL~Please Enter Correct Email ID~DM~"/></td>

</tr>

<tr>

<td colspan="2">&nbsp;</td>

</tr>

<tr>

<td height="14" colspan="2" align="center">

<input type="hidden" name="start"  value="<?=$start?>"/>

<input type="hidden" name="nu_id"  value="<?=$nu_id?>"/>

<input type="submit" class="btn btn-info" class="button" name="send" value="Submit" /></td>

</tr>	   

</table>

</form>

<? include("bottom.inc.php");?>