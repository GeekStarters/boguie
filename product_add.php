<?php 
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
@extract($_POST);
$product_id=$_GET['product_id'];

/****************************** Add A new Product *************************************/
if(isset($_REQUEST['submit']))
	{
	$found=mysql_num_rows(db_query("select * from tbl_product where product_name='$_REQUEST[product_name]'"));
	
	if($found==0){
		$product_code	=	addslashes($_REQUEST['product_code']);
		$product_name	=	addslashes($_REQUEST['product_name']);
		$product_desc	=	addslashes($_REQUEST['product_desc']);
		$brand	=	addslashes($_REQUEST['brand']);
		$product_price = $_REQUEST['product_price'];
		$sale_price = $_REQUEST['sale_price'];
		
		if($_FILES[product_image1][size]>0)
		{
			$product_images_1	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[product_image1]['name']);
			$product_images_1	 = str_replace(' ','-',$product_images_1);
			copy($_FILES[product_image1]['tmp_name'], "product_images/".$product_images_1) or die("Image is not uploaded");	
			
			$thumb2 = new Thumbnail("product_images/$product_images_1");
			$thumb2->resize("600","725");
			$thumb2->save("product_images/large/$product_images_1","100%");
			
			$thumb = new Thumbnail("product_images/$product_images_1");
			$thumb->resize("150","200");
			$thumb->save("product_images/$product_images_1","100%");
		}
		if($_FILES[product_image2][size]>0)
		{
			$product_images_2	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[product_image2]['name']);
			$product_images_2	 = str_replace(' ','-',$product_images_2);
			copy($_FILES[product_image2]['tmp_name'], "product_images/".$product_images_2) or die("Image is not uploaded");	
			
			$thumb2 = new Thumbnail("product_images/$product_images_2");
			$thumb2->resize("600","725");
			$thumb2->save("product_images/large/$product_images_2","100%");
			
			$thumb = new Thumbnail("product_images/$product_images_2");
			$thumb->resize("150","200");
			$thumb->save("product_images/$product_images_2","100%");
		}
		if($_FILES[product_image3][size]>0)
		{
			$product_images_3	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[product_image3]['name']);
			$product_images_3	 = str_replace(' ','-',$product_images_3);
			copy($_FILES[product_image3]['tmp_name'], "product_images/".$product_images_3) or die("Image is not uploaded");	
			
			$thumb2 = new Thumbnail("product_images/$product_images_3");
			$thumb2->resize("600","725");
			$thumb2->save("product_images/large/$product_images_3","100%");
			
			$thumb = new Thumbnail("product_images/$product_images_3");
			$thumb->resize("150","200");
			$thumb->save("product_images/$product_images_3","100%");
		}
		
		$sql_insert=mysql_query("insert into tbl_product set
		product_code='$product_code',
		product_name='$product_name',
		product_desc='$product_desc',
		product_cat_id='$cat_id',
		product_price ='$product_price',
		sale_price = '$sale_price',
		brand ='$brand',
		product_image1='$product_images_1',
		product_image2='$product_images_2',
		product_image3='$product_images_3',
		is_feature='N',
		is_new='Y',
		active_status='active'") or die(mysql_error());
		
		set_session_msg("Product has been added successfully");?>
		
		<script language="javascript">location.href='manage_product.php'</script>
		<? exit;
	}else{
		set_session_msg("Product already exist.");	
	}
	
}



/******************************************************************************************************/
if(isset($_REQUEST['update']))
{
	$found=mysql_num_rows(db_query("select * from tbl_product where product_name='$_REQUEST[product_name]' and product_id !='$_GET[product_id]'"));
	if($found==0)
	{
		$product_code	=	addslashes($_REQUEST['product_code']);
		$product_name	=	addslashes($_REQUEST['product_name']);
		$product_desc	=	addslashes($_REQUEST['product_desc']);
		$brand	=	addslashes($_REQUEST['brand']);
		$product_price = $_REQUEST['product_price'];
		$sale_price = $_REQUEST['sale_price'];
		
		if($_FILES[product_image1][size] > 0){
			$cat_res=mysql_fetch_array(db_query("select * from tbl_product where product_id='$product_id'"));
			if(strlen($cat_res[product_image1]) && file_exists("product_images/".$cat_res[product_image1])){
				unlink("/product_images/".$cat_res[product_image1]);
				unlink("/product_images/large/".$cat_res[product_image1]);
			}
			$product_images_1 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[product_image1]['name']);
			copy($_FILES[product_image1]['tmp_name'],"product_images/".$product_images_1) or die("Image is not uploaded");	
			
			$thumb2 = new Thumbnail("product_images/$product_images_1");
			$thumb2->resize("600","725");
			$thumb2->save("product_images/large/$product_images_1","100%");
						
			$thumb = new Thumbnail("product_images/$product_images_1");
			$thumb->resize("150","200");
			$thumb->save("product_images/$product_images_1","100%");
			
			db_query("update tbl_product set product_image1='".$product_images_1."' where product_id='".$product_id."'");	
		}
		
		if($_FILES[product_image2][size] > 0){
			$cat_res=mysql_fetch_array(db_query("select * from tbl_product where product_id='$product_id'"));
			if(strlen($cat_res[product_image2]) && file_exists("product_images/".$cat_res[product_image2])){
				unlink("/product_images/".$cat_res[product_image2]);
				unlink("/product_images/large/".$cat_res[product_image2]);
			}
			$product_images_2 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[product_image2]['name']);
			copy($_FILES[product_image2]['tmp_name'],"product_images/".$product_images_2) or die("Image is not uploaded");	
			
			$thumb2 = new Thumbnail("product_images/$product_images_2");
			$thumb2->resize("600","725");
			$thumb2->save("product_images/large/$product_images_2","100%");
						
			$thumb = new Thumbnail("product_images/$product_images_2");
			$thumb->resize("150","200");
			$thumb->save("product_images/$product_images_2","100%");
			
			db_query("update tbl_product set product_image2='".$product_images_2."' where product_id='".$product_id."'");	
		}
		
		if($_FILES[product_image3][size] > 0){
			$cat_res=mysql_fetch_array(db_query("select * from tbl_product where product_id='$product_id'"));
			if(strlen($cat_res[product_image3]) && file_exists("product_images/".$cat_res[product_image3])){
				unlink("/product_images/".$cat_res[product_image3]);
				unlink("/product_images/large/".$cat_res[product_image3]);
			}
			$product_images_3 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[product_image3]['name']);
			copy($_FILES[product_image3]['tmp_name'],"product_images/".$product_images_3) or die("Image is not uploaded");	
			
			$thumb2 = new Thumbnail("product_images/$product_images_3");
			$thumb2->resize("600","725");
			$thumb2->save("product_images/large/$product_images_3","100%");
						
			$thumb = new Thumbnail("product_images/$product_images_3");
			$thumb->resize("150","200");
			$thumb->save("product_images/$product_images_3","100%");
			
			db_query("update tbl_product set product_image3='".$product_images_3."' where product_id='".$product_id."'");	
		}
		
		$sql_update=mysql_query("update tbl_product set
		product_code='$product_code',
		product_name='$product_name',
		product_desc='$product_desc',
		product_cat_id='$cat_id',
		product_price ='$product_price',
		sale_price = '$sale_price',
		brand ='$brand',
		is_feature='N',
		active_status='active' where product_id='".$product_id."'") or die(mysql_error());
		
		set_session_msg("Product has been updated successfully");
		?>
		<script language="javascript">location.href='manage_product.php'</script>
		<? exit;
	}else{
		set_session_msg("Product already exist.");		
	}
}
if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$category_id=$_REQUEST['category_id'];
	$sql_fectch_city=mysql_query("select * from tbl_product  where product_id=$product_id") or die(mysql_error());
	$fetch_record=mysql_fetch_array($sql_fectch_city);
	@extract($fetch_record);
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script language="javascript" src="js/admin.js"></script>
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
		<th colspan="2"><? if($_REQUEST['set_flag']=='update') echo "Edit Product"; else echo "Add Product";?></th>
	</tr>
	<tr><td height="10"></td></tr>
	<tr>
		<td class="tdLabel" width="20%">Select Category <span class="star">*</span></td>
		<td class="tdLabel"><select name="cat_id" id="sproduct" style="width:200px; "/>
			<option value="">Select Catagory</option>
			<?php $sel="SELECT * FROM `tbl_category`";
			$exe=mysql_query($sel) or die("can't access");
			while($data=mysql_fetch_array($exe)){?> 
			<option value="<?=$data['cat_id']?>" <? if($fetch_record['product_cat_id']==$data['cat_id']){ echo "selected"; }?>><?=$data['cat_name']?></option>
			<? }?>
		</td>
	</tr>
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" width="20%">Product Code <span class="star">*</span></td>
		<td class="lightGrayBg"><input name="product_code"  size="48" type="text" value="<?=stripslashes($product_code)?>" /></td>
	</tr>
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" width="20%">Product Name <span class="star">*</span></td>
		<td class="lightGrayBg"><input name="product_name"  size="48" type="text" value="<?=stripslashes($product_name)?>" /></td>
	</tr>
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" valign="top" nowrap>Product Price <span class="star">*</span></td>
		<td class="lightGrayBg"><input name="product_price" size="8" type="text" value="<?=$product_price?>" />&nbsp;<strong>S/.</strong></td>
	</tr>
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" valign="top" nowrap>Sale Price <span class="star">*</span></td>
		<td class="lightGrayBg"><input name="sale_price" size="8" type="text" value="<?=$sale_price?>" />&nbsp;<strong>S/.</strong></td>
	</tr>
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" valign="bottom">Product Image 1</td>
		<td class="lightGrayBg"><input name="product_image1" type="file" > Upload Product Image
		<?php if($product_image1){?>
		<img src="product_images/<?=$product_image1?>" border="0" width="102" height="102"><br>
		<?php }?></td>
	</tr>
	<!--<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" valign="bottom">Product Image 2</td>
		<td class="lightGrayBg"><input name="product_image2" type="file" > Upload Product Image
		<?php //if($product_image2){?>
		<img src="product_images/<?php //echo $product_image2?>" border="0" width="102" height="102"><br>
		<?php //}?></td>
	</tr>
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td class="lightGrayBg" valign="bottom">Product Image 3</td>
		<td class="lightGrayBg"><input name="product_image3" type="file" > Upload Product Image
		<?php //if($product_image3){?>
		<img src="product_images/<?php //echo $product_image3?>" border="0" width="102" height="102"><br>
		<?php //}?></td>
	</tr>-->
	<tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
	<tr>
		<td valign="top" class="lightGrayBg">Product Description </td>
		<td class="lightGrayBg"><textarea name="product_desc" id="product_desc" rows="10" cols="50"><?=$product_desc?></textarea>
		<script type="text/javascript">
			CKEDITOR.config.toolbar = 'Basic';
			CKEDITOR.replace('product_desc',{
				height: '300px',
				width: '520px'
			});
		</script></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td align="center" colspan="2"><?php if($_REQUEST['set_flag']=='update'){?>
			<input type="submit" name="update" value='Edit' >
		<?php }else{?>
			<input type="submit" name="submit" value='Submit' >
		<?php }?></td>
	</tr>
</table>
</form>
<br />
<?php include("paging.inc.php");?>
</td>
</tr>
</table>
<?php include("bottom.inc.php");?>