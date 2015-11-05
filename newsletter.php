<? require_once("includes/main.inc.php");

/**for delete email newsletter**/
if(isset($_REQUEST['arr_news_ids'])){
	$arr_news_ids = $_REQUEST['arr_news_ids'];
	if(is_array($arr_news_ids)){
		$str_news_ids = implode(',', $arr_news_ids);
	
		if(isset($_REQUEST['Delete'])){
			$sql = "delete from  tbl_newsletter  where id in ($str_news_ids)";
			db_query($sql);
			set_session_msg("Selected email(s) have been deleted successfully");
		}
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from tbl_newsletter ";
$sql .= " order by id";

$sql_count = "select count(*) ".$sql;

$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
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
<td id="pageHead"><div id="txtPageHead">Manage Newsletter Email</div></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="content" align="left">
<div align="center"><strong class="msg"><?=display_sess_msg()?></strong></div>
<p style="height:2px;"></p>
<?php if(mysql_num_rows($result)==0){?>
<div class="msg">Sorry, no records found.</div>
<?php }else{ ?>
<div align="right"> Showing Records: <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?></div>
<p  style="height:2px;"></p>
<div align="left">Records Per Page: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
<form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
<tr>
  <th width="10%">SL<input name="check_all" type="checkbox" id="check_all" value="1" onClick="checkall(this.form)" /></th>
  <th nowrap="nowrap" align="left" valign="top">Email</th>
</tr>
<?php 
if($start==0){
	$cnt=0;
}else{
	$cnt=$start;
}
while ($line_raw = mysql_fetch_array($result)){
$cnt++;
$css = ($css=='trOdd')?'trEven':'trOdd';
?>
<tr class="<?=$css?>">
<td align="center" valign="top">&nbsp;&nbsp;<?=$cnt;?><input name="arr_news_ids[]" type="checkbox" id="arr_cat_ids[]" value="<?=$line_raw['id'];?>" /></td>
<td align="left" valign="top"><?=stripslashes($line_raw['email']);?></td>
</tr>
<?php }?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td align="right" style="padding:2px">
<p  style="height:10px;"></p>
<input name="Delete" type="submit" class="button" id="Delete" value="Delete"  onClick="return validcheck('arr_news_ids[]','delete','Newsletter Email');"/>
<p style="height:10px;"></p>
</td></tr>
</table>
</form>
<?php }?>
<? include("paging.inc.php");?>
</td>
</tr>
</table>
<? include("bottom.inc.php");?>