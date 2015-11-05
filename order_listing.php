<? require_once("includes/main.inc.php");

if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}
/**for activate delete and deactivate Orders**/


if(isset($_REQUEST['arr_ids'])){
	$arr_ids = $_REQUEST['arr_ids'];
	
	if(is_array($arr_ids)){
		@extract($_REQUEST);
		$arr_ids = $_REQUEST['arr_ids'];
		$str_ids = implode(',', $arr_ids);
		
		if(isset($_REQUEST['Delete'])){
			@extract($_REQUEST);
			$sql = "delete from  tbl_order  where id in ($str_ids)";
			db_query($sql);
			
			set_session_msg("Selected orders have been deleted successfully");
		}else if(isset($_REQUEST['Confirm']) || isset($_REQUEST['Activate_x'])){
			$sql = "update tbl_order set order_status = 'Confirmed' where id in ($str_ids)";
			db_query($sql);
			
			set_session_msg("Selected orders have been confirmed successfully");
		}else if(isset($_REQUEST['Delivered']) || isset($_REQUEST['Delivered_x'])){
			$sql = "update tbl_order set order_status = 'Delivered' where id in ($str_ids)";
			db_query($sql);
			
			#Auto Mail
			$order_member_id=mysql_fetch_array(db_query("select userid from tbl_order where id in($str_ids)"));
			$qry=db_query("select * from registration where id='".$order_member_id[id]."'");
			$res1=mysql_fetch_array($qry);
			$To=$res1[username];
			$from=ADMIN_EMAIL;
			
			$subject="Order Confirmation Mail!!";
			$msg ="Dear $res1[fname] $res1[lname],<br><br>Your order has been delivered successfully.<br><br>Thank you for shopping with us...<br><br>Best Regards<br>Team <br>".ADMIN_NAME;
			$headers = "From: ".ADMIN_NAME."<".ADMIN_EMAIL.">\n";
			$headers .= "X-Mailer: PHP/". phpversion();
			$headers .= "X-Priority: 3 \n";
			$headers .= "MIME-version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; 
			@mail("$To", "$subject", "$msg","$headers");			
			#End Auto Mail			
			set_session_msg("Selected orders have been Delivered successfully");
		}else if(isset($_REQUEST['Completed'])){
			$updateQuery = db_query("Select id,amt_topay+shipping_cost as topaid from tbl_order where id in ($str_ids)");
			while($updateData	=	mysql_fetch_array($updateQuery)){
				db_query("update tbl_order set amt_paid = '".$updateData[topaid]."', order_status='Completed' where id='".$updateData['id']."'");
			}			
		}else if(isset($_REQUEST['Notpaid'])){
			db_query("update tbl_order set amt_paid = '0', order_status	= 'Pending'	 where id in ($str_ids)");
		}
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

if($_GET['id']!='' && $_GET['status']!=''){
	echo $sql="update tbl_order set order_status='".$_GET[status]."' where id ='".$_GET['id']."'";
	$res=mysql_query($sql) or die(mysql_error());
	
	set_session_msg("Selected orders have been Update successfully");
	header("location:order_listing.php#des");
	exit;
}
/**End of checking***/

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select o.*, r.fname, r.lname, r.username ";
$sql = " from tbl_order o inner join registration r on o.userid=r.id ";
$sql .= " order by o.id";

$sql_count = "select count(*) ".$sql;
$sql .= " limit $start, $pagesize ";

$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);?>
<link href="styles.css" rel="stylesheet" type="text/css">
<SCRIPT src="calendarDateInput.js" type="text/javascript"></SCRIPT>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css" />	
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<!-- language for the calendar -->
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<!-- the following script defines the Calendar.setup helper function, which makes
adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="../js/validation.js"></script>
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
<td id="pageHead"><div id="txtPageHead">Manage Order</div></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="content" align="left">
<div align="center"><strong class="msg"><?=display_sess_msg()?></strong></center>
<form method="get" name="form2" id="form2" onSubmit="return confirm_submit(this)">
<br />
</form>
<?php if(mysql_num_rows($result)==0){?>
<div class="msg">Sorry, no records found.</div>
<?php }else{ ?>
<div align="right"> Showing Records: <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?></div>
<div align="left">Records Per Page: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
<form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
<tr>
<th width="5%">SL<input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
<th width="8%">Invoice No</th>
<th width="12%">Name</th>
<th width="10%">Email</th>
<th width="10%">Order Date</th>
<th width="15%">Payment Status</th>
</tr>
<?php if($start==0){
	$cnt=0;
}else{
	$cnt=$start;
}

while ($line_raw = mysql_fetch_array($result)){
	$cnt++;
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
<tr class="<?=$css?>">
<td align="center" valign="top"><?=$cnt;?><input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$line_raw['id'];?>" />
<input type="hidden" name="u_status_arr[]"  value="<?=($status=='Confirm')?'Confirmed':'Pending';?>" /></td>
<td align="center" valign="top"><?=$line_raw['id'];?></a></td>
<td align="center" valign="top"><?=$line_raw['fname'].' '.$line_raw['lname'];?></td>
<td align="center" valign="top"><?=$line_raw['username'];?></td>
<td align="center" valign="top"><?=$line_raw['date'];?></td>
<td align="center" valign="top">
<select name="sel" onchange="window.location='order_listing.php?status='+this.value+'&id=<?=$line_raw[id]?>'">
	<option value="">Select status</option>
	<option value="Pending" <?php if($line_raw['order_status']=='Pending'){ ?> selected="selected" <? } ?>>Pending</option>
	<option value="Confirmed" <?php if($line_raw['order_status']=='Confirmed'){ ?> selected="selected" <? } ?>>Confirmed</option>
	<option value="Cancel" <?php if($line_raw['order_status']=='Cancel'){ ?> selected="selected" <? } ?>>Cancel</option>
</select>
<br />
<? echo $line_raw['order_status'];?>
</td>
</tr>
<?php }?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="right" style="padding:2px"><input name="Delete" type="submit" class="button" id="Delete" value="Delete"  onClick="return validcheck('str_ids[]','Delete','Order');"/></td>
</tr>
</table>
</form>
<?php }?>
<? include("paging.inc.php");?>
</td>
</tr>
</table>
<? include("bottom.inc.php");?>