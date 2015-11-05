<?php require_once ('includes/main.inc.php'); 
if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}

if(is_post_back()) {


			$sql="update tbl_admin set 	


						admin_email='$email',

						paypal_account='$paypal_account',
						
						admin_site_owner='$admin_site_owner',


						admin_address='$admin_address',


						admin_city='$admin_city',


						admin_state='$admin_state',


						admin_country='$admin_country',


						admin_post_code='$admin_post_code',


						admin_site_root='$admin_site_root'


						where admin_id= '".$_SESSION['sess_admin_id']."'";


			DB_QUERY($sql);


			header("Location: manage_config.php");


}


?>


<? include_once('top.inc.php'); 


$sel=db_query("select * from tbl_admin where admin_id= '".$_SESSION['sess_admin_id']."'");


$rw=mysql_fetch_array($sel);


#	echo "<pre>"; print_r($rw);


 $rw=ms_stripslashes($rw);


?>


<script src="../js/admin.js"></script>


<script>


function checkpankaj(frm){


if(frm.email.value=='')


	{


		alert("Enter Email");


		frm.email.focus();


		return false;


		}


if(!isValidEmailStrict(frm.email.value))


	{


		alert("Enter Valid Email");


		frm.email.focus();


		return false;


		}	


if(frm.admin_site_root.value=='')


	{


		alert("Enter Site Url");


		frm.admin_site_root.focus();


		return false;


		}


if(frm.admin_address.value=='')


	{


		alert("Enter Site Address");


		frm.admin_address.focus();


		return false;


		}


if(frm.admin_city.value=='')


	{


		alert("Enter City");


		frm.admin_city.focus();


		return false;


		}


if(frm.admin_state.value=='')


	{


		alert("Enter State");


		frm.admin_state.focus();


		return false;


		}


if(frm.admin_country.value=='')


	{


		alert("Enter Country");


		frm.admin_country.focus();


		return false;


		}	


if(frm.admin_post_code.value=='')


	{


		alert("Enter Post Code");


		frm.admin_post_code.focus();


		return false;


		}	


									


			


return true;


}


</script>


<link href="styles.css" rel="stylesheet" type="text/css">


<table width="100%" border="0" cellspacing="0" cellpadding="0">


  <tr>


    <td id="pageHead"><div id="txtPageHead">Site Configuration


    </div></td>


  </tr>


</table>


<form action="" method="post" name="form1" id="form1" onsubmit="javascript:return checkpankaj(this);"> 


	<table width="358" border="0" align="center" cellpadding="0" cellspacing="0" class="tableForm"> 


	<tr>


		<td class="tdLabel" colspan="2" align="center"><font color="#C05813"><?=display_sess_msg()?></font></td>


	</tr>


	


	<tr> 


		<td class="tdLabel">Contact Email:</td> 


		<td> <input type="text" name="email" class="textfield" alt="NOBLANK~Email~DM~EMAIL~Email~DM~" value="<?=$rw['admin_email'];?>" size="40"> 


		</td> 


	</tr>


	<tr><td colspan="2"><hr></td></tr>


	<tr>


		<td colspan="2"><b>Other Settings</b></td>


	</tr>


 <!--   <tr> 


		<td width="120" class="tdLabel">Site Root:</td> 


	  <td><input type="text" name="admin_site_root" class="textfield" alt="NOBLANK~Name~DM~" value="<?=$rw['admin_site_root'];?>" size="40">	   


	     <br />( eg. http://www.myspace.com/)</td> 


	</tr> 

-->
    
    
     


<tr> 


		<td width="120" class="tdLabel">Paypal Account:</td> 


		<td><input type="text" name="paypal_account" class="textfield" alt="NOBLANK~Name~DM~" value="<?=$rw['paypal_account'];?>" size="40"> </td> 


	</tr> 



	<tr> 


		<td width="120" class="tdLabel">Site Name:</td> 


		<td><input type="text" name="admin_site_owner" class="textfield" alt="NOBLANK~Name~DM~" value="<?=$rw['admin_site_owner'];?>" size="40"> </td> 


	</tr> 


	<tr> 


		<td class="tdLabel">Address:</td> 


		<td> <input type="text" name="admin_address" class="textfield" alt="NOBLANK~Address~DM~" value="<?=$rw['admin_address'];?>" size="40"> 


		</td> 


	</tr>


	<tr> 


		<td width="120" class="tdLabel">City:</td> 


		<td><input type="text" name="admin_city" class="textfield" alt="NOBLANK~City~DM~" value="<?=$rw['admin_city'];?>" size="40"> </td> 


	</tr> 


	<tr> 


		<td width="120" class="tdLabel">State:</td> 


		<td><input type="text" name="admin_state" class="textfield" alt="NOBLANK~State~DM~" value="<?=$rw['admin_state'];?>" size="40"> </td> 


	</tr> 


	<tr> 


		<td width="120" class="tdLabel">Country:</td> 


		<td><input type="text" name="admin_country" class="textfield" alt="NOBLANK~Country~DM~" value="<?=$rw['admin_country'];?>" size="40"> </td> 


	</tr> 


	<tr> 


		<td width="120" class="tdLabel">Post Code:</td> 


		<td><input type="text" name="admin_post_code" class="textfield" alt="NOBLANK~Post Code~DM~" value="<?=$rw['admin_post_code'];?>" size="40"> </td> 


	</tr> 


	<tr>


		<td class="label">&nbsp;</td>


		<td><input type="image" name="imageField" src="images/buttons/submit.gif" /></td>


	</tr> 


	</table> 


</form>


<? include ('bottom.inc.php'); ?>