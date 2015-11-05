<? require_once("includes/main.inc.php");

/**for activate delete and deactivate Driver**/


/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql=" from tbl_user where usertype='passenger' ";
if($keyword!=""){
	switch($type){
		case 'fullname':
			$sql .=" And fullname like '%$keyword%' ";
			break;
		case 'email':
			$sql .=" And email like '%$keyword%' ";
			break;
	}
}

$sql .= " order by id";

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
<td id="pageHead"><div id="txtPageHead">Manage Passenger Balance Report</div></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="content" align="left">
<strong class="msg"><div align="center"><?=display_sess_msg()?></div></strong>
<p align="center"></p>
<p></p>
<?
if(mysql_num_rows($result)==0){?>
<div class="msg">Sorry, no records found.</div>
<?
}else{ ?>
<div align="right"> Showing Records: <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?></div>
<div align="left">Records Per Page: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
<p style="height:2px;"></p>
<form method="post" name="form1" id="form1" onsubmit="">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
<tr>
<th width="5%">SL</th>
<th width="20%" nowrap="nowrap">Passenger Name</th>
<th width="15%">Balance</th>
<th width="15%">Paid yet</th>

</tr>
<?
if($start==0){
	$cnt=0;
}else{
	$cnt=$start;
}

while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
	$cnt++;
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
<tr class="<?=$css?>">
<td align="center" valign="top"><?=$cnt;?><input type="hidden" name="u_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td>
<td align="left" valign="top"><?=stripslashes($line_raw['fullname']);?>
<td align="left" valign="top"><?=stripslashes($line_raw['balance']);?>
<td align="left" valign="top"><?=stripslashes($line_raw['paid_yet']);?>
</tr>
<?php }?>
</table>


</form>
<?php }?>
<?php include("paging.inc.php");?>
</td>
</tr>
</table>
<?php include("bottom.inc.php");?>