<?php 
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
@extract($_POST);

/****************************** Add A new Product *************************************/
if(isset($_REQUEST['submit']))
{
	$found=mysql_num_rows(db_query("select * from tbl_catelogue"));
	
	if($found==0){
		if($_FILES[catalog][size]>0)
		{
			$catalog_1	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[catalog]['name']);
			$catalog_1	 = str_replace(' ','-',$catalog_1);
			copy($_FILES[catalog]['tmp_name'], "product_images/".$catalog_1) or die("Image is not uploaded");	
		}
		
		$sql_insert=mysql_query("insert into tbl_catelogue set catalogue='$catalog_1'") or die(mysql_error());
		set_session_msg("Catalogue has been added successfully");?>
		
		<script language="javascript">location.href='upload_catalog.php'</script>
		<? exit;
	}else{
		$sql = "select * from tbl_catelogue";
		$rs = mysql_query($sql);
		$rc = mysql_fetch_array($rs);
		if(file_exists("product_images/".$rc['catalogue'])){
			unlink("product_images/".$rc['catalogue']);
		}
		if($_FILES[catalog][size]>0)
		{
			$catalog_1	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[catalog]['name']);
			$catalog_1	 = str_replace(' ','-',$catalog_1);
			copy($_FILES[catalog]['tmp_name'], "product_images/".$catalog_1) or die("Image is not uploaded");	
		}
		
		$sql_insert=mysql_query("update tbl_catelogue set catalogue='$catalog_1'") or die(mysql_error());
		set_session_msg("Catalogue has been updated successfully");?>
		
		<script language="javascript">location.href='upload_catalog.php'</script>
		<? exit;
	}
}
/******************************************************************************************************/

$sql_fectch_city=mysql_query("select * from tbl_catelogue") or die(mysql_error());
$fetch_record=mysql_fetch_array($sql_fectch_city);
@extract($fetch_record);
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ajax_sproduct.js"></script>
<script language="javascript" src="../js/jquery-1.3.2.min.js"></script>

<? include("top.inc.php");?><center class="msg"><?=$msg;?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td id="pageHead"><div id="txtPageHead"><?php if($_REQUEST['set_flag']=='update') echo "Edit Product"; else echo "Add Product";?></div></td></tr>
</table>
<div align="right" style="padding-right:5px;"><a href="<?=$_SERVER[HTTP_REFERER]?>">Back to Product Listings </a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="content" align="center"><strong class="msg"><?=display_sess_msg()?></strong>
	<form method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate(this);">
	<br />
	`<table  border="0" width="70%"align="center" cellpadding="2" cellspacing="0" class="tableSearch">
	<tr align="center">
		<th colspan="2">Add/Update Catalogue</th>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td class="lightGrayBg" valign="middle">Catalogue</td>
		<td class="lightGrayBg"><input name="catalog" type="file" > Upload Catalogue File
		<?php if($catalogue){?>
		<br><a href="product_images/<?=$catalogue?>" target="_blank">View Catalogue</a>
		<?php }?></td>
	</tr>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td align="center" colspan="2"><input type="submit" class="btn btn-info"  name="submit" value='Submit' ></td></tr>
</table>
</form>
<br />
<?php include("paging.inc.php");?>
</td>
</tr>
</table>
<?php include("bottom.inc.php");?>