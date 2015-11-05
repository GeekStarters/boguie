<?php require_once("includes/main.inc.php");

if($_SESSION['sess_admin_id']==''){
	header("location:index.php");
}

/**for activate, delete and deactivate member**/
if(isset($_REQUEST['arr_ids'])){
	$arr_ids = $_REQUEST['arr_ids'];
	
	if(is_array($arr_ids)) {
		$str_ids = implode(',', $arr_ids);
		
		if(isset($_REQUEST['Delete']) ) {
			$sql = "delete from   registration  where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Selected member have been deleted successfully");
		}else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x']) ) {
			$sql = "update registration  set status = 'Active' where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Selected member have been activated successfully");
		}else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x']) ) {
			$sql = "update registration  set status = 'Inactive' where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Selected member have been deactivated successfully");
		}
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}
/**End of checking***/

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from registration where 1 and status!='Delete'";

if($keyword!=""){
	switch($type){
		case 'name':
			$sql .=" And fname like '%$_REQUEST[keyword]%' OR lname like '%$_REQUEST[keyword]%' ";
			break;
		case 'email':
			$sql .=" And username like '%$_REQUEST[keyword]%' ";
			break;
	}
}

$sql .= " order by id desc";
$sql_count = "select count(*) ".$sql; 
$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td id="pageHead"><div id="txtPageHead">Manage Member</div></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="content" align="center"><strong class="msg"><?=display_sess_msg()?></strong>			
	<form method="get" name="form2" id="form2" onSubmit="return confirm_submit(this)">
	<br />
	<table width="40%"  border="0" align="center" cellpadding="2" cellspacing="0" class="tableSearch">
		<tr align="center"><th colspan="3">Search Member</th></tr>
		<tr>
			<td width="20%" class="tdLabel">Keyword: </td>
			<td width="80%"><input name="keyword" type="text" value="<?=$keyword?>" />
			<select name="type">
				<option value="name" <? if($type=="name"){ echo "selected";}?>>Name</option>
				<option value="email" <? if($type=="email"){ echo "selected";}?>>Email</option>
			</select></td>
			<td><input type="image" name="imageField" src="images/buttons/search.gif" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center"><a href="member_listing.php">View All</a><input name="pagesize" type="hidden" id="pagesize" value="<?=$pagesize?>" /></td>
		</tr>
	</table>
	</form>
	<?php if(mysql_num_rows($result)==0){?>
	<div class="msg">Sorry, no records found.</div>
	<?php }else{?>
	<div align="right">Showing Records: <?= $start+1?> to <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> of <?= $reccnt?></div>
	<div align="left">Records Per Page: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
	<form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
	<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
	<tr>
		<th width="8%">SL<input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
		<th width="5%">&nbsp;</th>
		<th width="15%">Name</th>
		<th width="15%">Email</th>
		<th width="8%">Password</th>
		<th width="10%">Status</th>
		<th width="10%">Register Date</th>
		<th width="10%">&nbsp;</th>
	</tr>
	<?php



					if($start==0){



						$cnt=0;



					}



					else{



						$cnt=$start;



					}



					$no_of_buyer='';



					while ($line_raw = mysql_fetch_array($result)) {



						$cnt++;



						$css = ($css=='trOdd')?'trEven':'trOdd';



						$m_id=$line_raw['id'];



						



						?>



					<tr class="<?=$css?>">



						<td align="center" valign="top">



							<?=$cnt;?> <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$line_raw['id'];?>" /><input type="hidden" name="m_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td><td align="center" valign="top"><a href="member_edit.php?id=<?=$line_raw['id']?>&set_flag=update">



							<img src="images/icons/edit.png" alt="Edit" width="16" height="16" border="0" /></a></td>



						<td align="left" valign="top"><?=$line_raw['fname'].' '.$line_raw['lname'];?></strong></td>



						<td align="left" valign="top"><?=$line_raw['username'];?></strong></td>



						<td align="left" valign="top"><?=$line_raw['upass'];?></strong></td>



						



						<td align="center" valign="top"><?=$line_raw['status'];?></td>



						<td align="center" valign="top"><?php $dtarr = explode('-',$line_raw['date']);
						echo date('d-M-Y',mktime(0,0,0,$dtarr[1],$dtarr[2],$dtarr[0]));?></td>



						<td align="center" valign="top"><a href="javascript:void(0);" onclick="javascript:window.open('member-details.php?id=<?=$line_raw[id]?>','','width=400,height=500,scrollbars=yes,left=100');">Details</a>



						   </td>



					</tr>



					<? 



				}



				?>



			</table>



			



			<table width="100%" border="0" cellspacing="0" cellpadding="0">



				<tr>



					<td align="right" style="padding:2px">



						<input name="Activate" type="submit"  value="Activate" class="button" id="Activate"   onClick="return validcheck('arr_ids[]','Activate','Member');"/>



						<input name="Deactivate" type="submit" class="button" value="Deactivate" id="Deactivate"  onClick="return validcheck('arr_ids[]','Deactivate','Member');"/>



						<input name="Delete" type="submit" class="button" id="Delete" value="Delete"  onClick="return validcheck('arr_ids[]','delete','Member');"/>



					</td>



				</tr>



			</table>



			</form>



			<? 



		}?>



		<? include("paging.inc.php");?></td>



	</tr>



</table>



<? include("bottom.inc.php");?>