<? require_once ('includes/main.inc.php'); 

if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}
if(is_post_back()) {


#	import_request_variables('p');





			$sql="update tbl_admin set


			admin_site_owner 		=	 '".$_REQUEST[admin_site_owner]."',


			admin_site_root 		=	 '".$_REQUEST[admin_site_root]."',


			admin_send_email		=	 '".$_REQUEST[admin_send_email]."',


			admin_address			= 	 '".$_REQUEST[admin_address]."',


			admin_city				= 	 '".$_REQUEST[admin_city]."',


			admin_state				=    '".$_REQUEST[admin_state]."',


			admin_country			= 	 '".$_REQUEST[admin_country]."',


			admin_post_code			= 	 '".$_REQUEST[admin_post_code]."'


			where admin_id= '".$_SESSION['sess_admin_id']."'";


			db_query($sql);


			$msg	=	urlencode("Admin Setting Updated Sucessfully");


			header("Location: change_setting.php?msg=$msg");


}


$settingQuery	=	db_query("select admin_site_owner,admin_site_root,admin_send_email,admin_address,admin_city,admin_state,


								admin_country,admin_post_code  from tbl_admin where admin_id= '".$_SESSION['sess_admin_id']."'");


$line_raw = mysql_fetch_array($settingQuery);


@extract($line_raw);





?>


<? include ('top.inc.php'); ?>


<link href="styles.css" rel="stylesheet" type="text/css">


<table width="100%" border="0" cellspacing="0" cellpadding="0">


  <tr>


    <td id="pageHead"><div id="txtPageHead">Change Password </div></td>


  </tr>


</table>


<form action="" method="post" name="form1" id="form1" onsubmit="return validate(this);">


  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm">


    <tr>


      <td class="tdLabel" colspan="2" align="center"><font color="#C05813">


        <?=display_sess_msg()?></font><?php if($_GET['msg']){ ?><br /> <span style="color:#009900; font-weight:bold"><?php echo $_GET['msg']; }?></span>


        </td>


    </tr>


    <tr>


      <td width="120" class="tdLabel">Site Root: *</td>


      <td><input type="admin_site_root" name="admin_site_root" size="40" class="textfield" id="NOBLANK~Please Enter Site Root~DM~" value="<?=$admin_site_root?>">


      </td>


    </tr>


    <tr>


      <td class="tdLabel">Name: *</td>


      <td><input type="admin_site_owner" name="admin_site_owner" size="40" class="textfield" id="NOBLANK~Please Enter Admin Site Owner~DM~" value="<?=$admin_site_owner?>">


      </td>


    </tr>


    <tr>


      <td class="tdLabel">Email: *</td>


      <td><input type="admin_send_email" name="admin_send_email" size="40" class="textfield" id="NOBLANK~Please Enter Email~DM~EMAIL~Enter Valid Email~DM~" value="<?=$admin_send_email?>">


      (To send email)</td>


    </tr>





    <tr>


      <td class="tdLabel">Address: *</td>


      <td><textarea name="admin_address" class="textfield" rows="4" cols="37" id="NOBLANK~Please Enter Site Address~DM~"><?=$admin_address?></textarea>


      </td>


    </tr>


     <tr>


      <td class="tdLabel">City: *</td>


      <td><input type="admin_city" name="admin_city" size="40" value="<?=$admin_city?>" class="textfield" id="NOBLANK~Please Enter City~DM~">


      </td>


    </tr>


     <tr>


      <td class="tdLabel">State: *</td>


      <td><input type="admin_state" name="admin_state" size="40"  class="textfield" value="<?=$admin_state?>" id="NOBLANK~Please Enter State~DM~">


      </td>


    </tr>


     <tr>


      <td class="tdLabel">Country: *</td>


      <td><input type="admin_country" name="admin_country" size="40"  class="textfield" value="<?=$admin_country?>" id="NOBLANK~Please Enter Admin Country~DM~">


      </td>


    </tr>


     <tr>


      <td class="tdLabel">Post Code: *</td>


      <td><input type="admin_post_code" name="admin_post_code" size="40"  class="textfield" value="<?=$admin_post_code?>" id="NOBLANK~Please Enter Post Code~DM~">


      </td>


    </tr>


    <tr>


      <td class="label">&nbsp;</td>


      <td><input type="image" name="imageField" src="images/buttons/submit.gif" /></td>


    </tr>


  </table>


</form>


<? include ('bottom.inc.php'); ?>


