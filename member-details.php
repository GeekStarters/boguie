<?
require_once('includes/main.inc.php');
$sql_fectch_city=mysql_query("select  * from registration  where id='".$_REQUEST['id']."'") or die(mysql_error());
$fetch_record=mysql_fetch_array($sql_fectch_city);
@extract($fetch_record);
?>
<html>
<head>
	<title>Member Details</title>
	<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
	<table  border="0" align="center" width="100%" cellpadding="2" cellspacing="0" class="tableSearch">
		<tr bgcolor="#f1f1f1">
			<td valign="top"class="tdLabel" colspan="3" align="center"><b>Member Details</b></td>
		</tr>
		
		<tr>
			<td valign="top" colspan="3"></td>
		</tr>
		<tr bgcolor="#f1f1f1">
			<td valign="top"class="tdLabel" colspan="3"><b><font color="#C05813">Login Info </font></b></td>
		</tr>
		<tr>
			<td valign="top" colspan="3"></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Email Id/Username</b></td>
			<td class="tdLabel"><?=$username?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Password</b></td>
			<td class="tdLabel"><?=$upass?></td>
		</tr>
		
		<tr bgcolor="#f1f1f1">
			<td valign="top"class="tdLabel" colspan="3"><b><font color="#C05813">Personal Details</font></b></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>First Name</b></td>
			<td class="tdLabel"><?=$fname?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Last Name</b></td>
			<td class="tdLabel"><?=$lname?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Telephone No</b></td>
			<td class="tdLabel"><?=$phone?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Fax</b></td>
			<td class="tdLabel"><?=$fax?></td>
		</tr>
		<tr bgcolor="#f1f1f1">
			<td valign="top"class="tdLabel" colspan="3"><b><font color="#C05813">Billing/Shipping Address</font></b></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Address</b></td>
			<td class="tdLabel"><?=nl2br($address)?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>City</b></td>
			<td class="tdLabel"><?=$city?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>State</b></td>
			<td class="tdLabel"><?=$state?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Country</b></td>
			<td class="tdLabel"><?=$country?></td>
		</tr>
		<tr>
			<td valign="top" class="tdLabel"><b>Zip Code</b></td>
			<td class="tdLabel"><?=$zipcode?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>
		</tr>
	</table>
	<div align="center"><strong><a href="javascript:window.close();">Close Window</a></strong></div>




</body>
</html>
