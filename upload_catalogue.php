<? require_once("includes/main.inc.php");

if(isset($_REQUEST['submit']))
{
	if($_FILES[catalogue][size]>0)
	{
		$catalogue	 = 'catalogue.pdf';
		copy($_FILES['catalogue']['tmp_name'], "../images/".$catalogue) or die("Catalogue is not uploaded");	
		set_session_msg("Catalogue has been uploaded successfully");
	}
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">
function validateCForm(obj)
{
	if(obj.catalogue.value == ""){
		alert("Please select any PDF file to upload.");
		obj.catalogue.focus();
		return false;
	}else{
		var fls = obj.catalogue.value.split('.');
		var ext = fls[fls.length-1];
		if(ext.toLowerCase() != 'pdf'){
			alert("Please select only valid file format. \nOnly PDF file will be accepted.");
			obj.catalogue.focus();
			return false;
		}
	}
}
</script>
<? include("top.inc.php");?>
<center class="msg"><?=$msg;?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td id="pageHead"><div id="txtPageHead">Upload Catalogue</div></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td id="content" align="center"><strong class="msg"><?=display_sess_msg()?></strong>
		<div align="right"><a href="manage_category.php">Back to Manage Category</a></div>
		<form method="post" name="form2" id="form2" enctype="multipart/form-data" onsubmit="return validateCForm(this);">
		<br />
		<table width="704"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
		<tr align="center">	<th colspan="2">Upload Catalogue</th></tr>
		<tr align="center"><td colspan="2"></td></tr>
		<tr>
			<td class="tdLabel" valign="bottom"> Upload Catalogue</td>
			<td class="tdLabel"><input name="catalogue" type="file" /> Upload Catalogue (Only PDF format)
			<?php if(file_exists("../images/catalogue.pdf")){?><a href="../images/catalogue.pdf" target="_blank">View Catalogue</a><br><?php } ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center"><input type="submit" class="btn btn-info" name="submit" value='Upload' ></td>
		</tr>
		</table>
		</form>
		<br /></td>
	</tr>
</table>
<?php include("bottom.inc.php");?>