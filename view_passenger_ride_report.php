<? require_once("includes/main.inc.php");

/**for activate delete and deactivate Driver**/

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql=" from tbl_user u INNER JOIN tbl_ride r ON u.id=r.passenger where u.usertype='passenger' and u.id='".$_REQUEST['did']."' ";
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
<td id="pageHead"><div id="txtPageHead">Manage Carrier Report</div></td>
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
<th width="4%">SL</th>
<th width="11%" nowrap="nowrap">Passenger Name</th>
<th width="13%" nowrap="nowrap">Cab Name</th>
<th width="14%" nowrap="nowrap">Puckup Date & time</th>
<th width="21%" nowrap="nowrap">Pickup Address</th>
<th width="13%" nowrap="nowrap">Dropoff time</th>
<th width="17%" nowrap="nowrap">Dropoff Address</th>
<th width="7%">Status</th>
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
<?php $sql="select * from tbl_cab where id='".$line_raw['cab']."'";
$rs=mysql_query($sql);
$rss=mysql_fetch_array($rs);?><td align="center" valign="top"><?=$cnt;?><input type="hidden" name="u_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td>
<td align="left" valign="top"><?=stripslashes(ucwords($line_raw['fullname']));?></td>
<td align="left" valign="top"><?=ucwords($rss['cab_number']);?></td>
<td align="left" valign="top"><?=$line_raw['pickup_date'];?> & <?=$line_raw['pickup_time'];?> </td>
<td align="left" valign="top"><?=ucwords($line_raw['pickup_address']);?></td>
<td align="left" valign="top"><?=$line_raw['dropoff_time'];?></td>
<td align="left" valign="top"><?=ucwords($line_raw['dropoff_address']);?></td>
<td align="center" valign="top"><?=($line_raw['status'])?></td>
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