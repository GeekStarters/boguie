<? require_once("../includes/main.inc.php");

/**for activate delete and deactivate Product**/
if(isset($_REQUEST['arr_product_ids'])){
$arr_product_ids = $_REQUEST['arr_product_ids'];
if(is_array($arr_product_ids)){
$str_product_ids = implode(',', $arr_product_ids);
if(isset($_REQUEST['Delete'])){
$sql = "update tbl_product  set active_status='Delete' where product_id in ($str_product_ids)";
db_query($sql);
set_session_msg("Selected products have been deleted successfully");
}
else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x'])){
$sql = "update tbl_product  set active_status = 'Active' where product_id in ($str_product_ids)";
db_query($sql);

set_session_msg("Selected products have been activated successfully");
}
else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x'])){
$sql = "update tbl_product  set active_status = 'Inactive' where product_id in ($str_product_ids)";
db_query($sql);

set_session_msg("Selected products have been deactivated successfully");
}
else if(isset($_REQUEST['setfeature'])){
$sql = "update tbl_product set is_feature = 'Y' where product_id in ($str_product_ids)";
db_query($sql);
set_session_msg("Selected products have been set for latest design");
}
else if(isset($_REQUEST['unsetfeature'])){
$sql = "update tbl_product  set is_feature = 'N' where product_id in ($str_product_ids)";
db_query($sql);
set_session_msg("Selected products have been unset for latest design");
}
else if(isset($_REQUEST['setnew'])){
$sql = "update tbl_product set is_new = 'Y' where product_id in ($str_product_ids)";
db_query($sql);
set_session_msg("Selected products have been set for new arrival");
}
else if(isset($_REQUEST['unsetnew'])){
$sql = "update tbl_product  set is_new = 'N' where product_id in ($str_product_ids)";
db_query($sql);
set_session_msg("Selected products have been unset for new arrival");
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
$sql .= " order by product_name";

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="pageHead"><div id="txtPageHead">Manage Product</div></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="content" align="left">
<strong class="msg"><div align="center"><?=display_sess_msg()?></div></strong>
<form method="get" name="form2" id="form2" onSubmit="return confirm_submit(this)">
<br />
<table width="55%"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
<tr align="center">
<th colspan="3">Search Product</th>
</tr>
<tr>
<td width="36%" class="tdLabel">Keyword: </td>
<td width="64%"><input name="keyword" type="text" value="<?=$keyword?>" />
<select name="type">
<option value="product_name" <? if($type=="product_name"){ echo "selected";}?>>Product Name</option>
<option value="product_code" <? if($type=="product_code"){ echo "selected";}?>>Product Code</option>
</select>
</td>
<td><input type="image" name="imageField" src="images/buttons/search.gif" /></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="<?=$_SERVER[PHP_SELF]?>">Show All</a></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<input name="parent_id" type="hidden" id="pagesize" value="<?=$_REQUEST[parent_id]?>" />
<input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" /></td>
</tr>
</table>
</form>
<div align="left" style="padding-right:15px;"><a href="category_listing.php">Back to Category Listings </a></div>
<div align="right">
<a href="product_add.php?set_flag=add&start=<?=$start?><?=($parent_id!='')?"&parent_id=$parent_id":""?>">Add New Product </a>
</div>
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
<div align="right"><font color="red">*</font> Sign indicates latest design.</div><!--
<div align="right"><img src="images/new.gif"> indicates new arrival.</div>-->
<form method="post" name="form1" id="form1" onsubmit="">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
<tr>
<th width="6%">SL<input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
<th width="3%">&nbsp;</th>
<th width="21%" nowrap="nowrap">Product Name</th>

<th width="8%">Price</th>

<th width="10%">Image</th>
<th width="8%">Status</th>
<th width="15%">&nbsp;</th>
<th width="15%">Similar Products</th>
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
<td align="center" valign="top">
<?=$cnt;?>
<input name="arr_product_ids[]" type="checkbox" id="arr_product_ids[]" value="<?=$line_raw['product_id'];?>" />
<input type="hidden" name="u_status_arr[]"  value="<?=($active_status=='Active')?'Active':'Inactive';?>" />
</td>
<td align="center" valign="top">
<a href="product_add.php?product_id=<?=$line_raw['product_id']?>&set_flag=update<?=$_REQUEST[parent_id]!=''?'&parent_id='.$_REQUEST[parent_id]:''?>">
<img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" />
</a>
</td>
<td align="left" valign="top"><?=stripslashes($line_raw['product_name']);?><?=($line_raw['is_feature']=='Y')?"<font color='red'>*</font>":""?><? if($line_raw['is_feature']=='Y'){?><img src='images/new.gif'/><?php }?><br />(Category Name := <?php displaycategoryName($line_raw['product_cat_id']);?>)</td>

<td align="center" valign="top">
<?=CURRANCY_SYMBOL.$line_raw['product_price'];?></td>

<td align="center">
<?
#echo $line_raw['product_image1'].'-------';
if($line_raw['product_image1']!='' && file_exists("cat_image/".$line_raw['product_image1'])){

$product_image2="cat_image/".$line_raw['product_image1'];
?>
<img src="<?=$product_image2?>" border="0" width="102" height="102"><br>

<? 
}
?>
</td>
<td align="center" valign="top"><?=$line_raw['active_status'];?></td>
<td align="center" valign="top"><!--<a href="javascript:void(0);" onclick="javascript:window.open('related_product.php?product_id=<?=$line_raw[product_id]?>','','width=600,height=600,scrollbars=yes,left=100');">Set Related Products</a> <br> <a href="javascript:void(0);" onclick="javascript:window.open('view_related.php?product_id=<?=$line_raw[product_id]?>','','width=600,height=600,scrollbars=yes,left=100');">View Related Products</a><br>--><a href="javascript:void(0);" onclick="javascript:window.open('product_details.php?product_id=<?=$line_raw[product_id]?>','','width=500,height=650,scrollbars=yes,left=100');">View Product Details</a><br>
<?
if(strlen($line_raw['video']) && file_exists(UP_FILES_FS_PATH."/video/".$line_raw['video'])){
?>
<a href="javascript:void(0);" onclick="javascript:window.open('view_video.php?product_id=<?=$line_raw[product_id]?>','','width=475,height=400,scrollbars=yes');">Play Video</a>
<?	
}
?>
</td>
<td align="center" valign="top"><a href="similar_products.php?product_cat_id=<?=$line_raw[product_cat_id];?>&product_id=<?=$line_raw[product_id]?>">View / Set Similar Products</a></td>
</tr>
<?
}?>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="right" style="padding:2px">
<input name="Activate" type="submit"  value="Activate" class="button" id="Activate" onClick="return validcheck('arr_product_ids[]','Activate','Product');"/>
<input name="Deactivate" type="submit" class="button" value="Deactivate" id="Deactivate"  onClick="return validcheck('arr_product_ids[]','Deactivate','Product');"/>
<input name="Delete" type="submit" class="button" id="Delete" value="Delete"  onClick="return validcheck('arr_product_ids[]','delete','Product');"/>
</td>
</tr>
</table>
</form>
<?
}
?>
<? include("paging.inc.php");?>
</td>
</tr>
</table>
<? include("bottom.inc.php");?>