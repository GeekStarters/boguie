<? require_once("includes/main.inc.php");

/**for activate delete and deactivate Product**/
if(isset($_REQUEST['arr_product_ids'])){
	$arr_product_ids = $_REQUEST['arr_product_ids'];
	if(is_array($arr_product_ids)){
		$str_product_ids = implode(',', $arr_product_ids);
		if(isset($_REQUEST['Delete'])){
			$sql = "delete from  tbl_product   where product_id in ($str_product_ids)";
			db_query($sql);
			set_session_msg("Selected products have been deleted successfully");
		}else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x'])){
			$sql = "update tbl_product  set active_status = 'Active' where product_id in ($str_product_ids)";
			db_query($sql);
			set_session_msg("Selected products have been activated successfully");
		}else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x'])){
			$sql = "update tbl_product  set active_status = 'Inactive' where product_id in ($str_product_ids)";
			db_query($sql);
			set_session_msg("Selected products have been deactivated successfully");
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql=($_REQUEST[parent_id]!='')?" from tbl_product where product_cat_id='$_REQUEST[parent_id]' and active_status!='Delete'":" from tbl_product where active_status!='Delete'";
if($keyword!=""){
	switch($type){
		case 'product_name':
			$sql .=" And product_name like '%$keyword%' ";
			break;
		case 'product_code':
			$sql .=" And product_code ='$keyword' ";
			break;
	}
}
if(isset($_REQUEST['cid'])) $sql .= " and product_cat_id='".$_REQUEST['cid']."'";
$sql .= " order by product_id";

$sql_count = "select count(*) ".$sql;

$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
//echo $sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
<script src="../js/validation.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>

<script language="javascript">
function checkall(objForm)
{
	len = objForm.elements.length;
	var i=0;
	
	for( i=0 ; i<len ; i++){
		if (objForm.elements[i].type=='checkbox'){
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="pageHead"><div id="txtPageHead">Manage Product</div></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="content" align="left">
<strong class="msg"><div align="center"><?=display_sess_msg()?></div></strong>
<p align="center"></p>
<div align="right">
<a href="product_add.php?set_flag=add&start=<?=$start?><?=($parent_id!='')?"&parent_id=$parent_id":""?>">Add New Product </a>
</div>
<p></p>
<?
if(mysql_num_rows($result)==0){?>
<div class="msg">Sorry, no records found.</div>
<?
}else{ ?>
<div align="right"> Showing Records:
<?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?>
</div>
<div align="left">Records Per Page:
<?=pagesize_dropdown('pagesize', $pagesize);?>
</div>
<p style="height:2px;"></p>
<form method="post" name="form1" id="form1" onsubmit="">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
<tr>
<th width="10%">SL<input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
<th width="5%">&nbsp;</th>
<th width="40%" nowrap="nowrap">Product Name</th>
<th width="15%" nowrap="nowrap">Price</th>
<th width="15%">Image</th>
<th width="15%">Status</th>
</tr>
<?
if($start==0){
$cnt=0;
}
else{
$cnt=$start;
}
while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
$cnt++;
$css = ($css=='trOdd')?'trEven':'trOdd';


?>
<tr class="<?=$css?>">
<td align="center" valign="top"><?=$cnt;?><input name="arr_product_ids[]" type="checkbox" id="arr_product_ids[]" value="<?=$line_raw['product_id'];?>" /><input type="hidden" name="u_status_arr[]"  value="<?=($active_status=='Active')?'Active':'Inactive';?>" /></td>
<td align="center" valign="top"><a href="product_add.php?product_id=<?=$line_raw['product_id']?>&set_flag=update<?=$_REQUEST[parent_id]!=''?'&parent_id='.$_REQUEST[parent_id]:''?>"><img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>
<td align="left" valign="top"><?=stripslashes($line_raw['product_name']);?><?=($line_raw['is_sale']=='Y')?"<font color='red'><small>&nbsp;&nbsp;On Sale</small></font>":""?><? if($line_raw['is_new']=='Y'){?>&nbsp;&nbsp;<img src='images/new.gif'/><?php }?><br />(Category Name := <?php displaycategoryName($line_raw['product_cat_id']);?>)</td>
<td align="right" valign="top">$ <?=$line_raw['product_price'];?> USD</td>
<td align="center"><?php if($line_raw['product_image1']!='' && file_exists("product_images/".$line_raw['product_image1'])){$product_image2="product_images/".$line_raw['product_image1'];?><img src="<?=$product_image2?>" border="0" width="50" ><?php }?></td>
<td align="center" valign="top"><?=$line_raw['active_status'];?></td>
</tr>
<?php }?>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="right" style="padding:2px"><p style="height:5px;"></p>
<input name="Activate" type="submit" value="Activate" class="button" onClick="return validcheck('arr_product_ids[]', 'Activate', 'Product');"/>
<input name="Deactivate" type="submit" class="button" value="Deactivate" onClick="return validcheck('arr_product_ids[]', 'Deactivate', 'Product');"/>
<input name="Delete" type="submit" class="button" value="Delete" onClick="return validcheck('arr_product_ids[]', 'delete', 'Product');"/>
<p></p>
</td>
</tr>
</table>
</form>
<?php }?>
<?php include("paging.inc.php");?>
</td>
</tr>
</table>
<?php include("bottom.inc.php");?>