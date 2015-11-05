<? require_once("includes/main.inc.php");

/*Member Add*/
if(isset($_REQUEST['submit'])){
	@extract($_POST);
	$found=mysql_num_rows(db_query("select * from tbl_member where email='$email' and status!='Delete'"));
	
	if($found==0){
		$full_name="$f_name $l_name";
		db_query("insert into tbl_member set f_name='".$f_name."', l_name='".$l_name."',full_name='".$full_name."', email='".$email."', pass='".$pass."',phone='".$phone."',fax='".$fax."',baddress='".$baddress."',bzip_code='".$bzip_code."', bcity='".$bcity."', bstate='".$bstate."', bcountry='".$bcountry."',saddress='".$saddress."',szip_code='".$szip_code."', scity='".$scity."', company_name='".$company_name."',sstate='".$sstate."', scountry='".$scountry."',status='Active',recv_date=now() ");
		
		set_session_msg("Member has been added successfully");
	?>
	<script language="javascript">location.href='member_listing.php'</script>
	<? exit;
	}
	else{
		set_session_msg("Username already exist.");
	}
}
/*Member Update*/
if(isset($_REQUEST['update'])){
	@extract($_POST);
	$member_id=$_REQUEST[member_id];
	
	$found=mysql_num_rows(db_query("select * from tbl_member where email='$email' and member_id!='$member_id' and status!='Delete'"));
	
	if($found==0){
		$full_name="$f_name $l_name";
		db_query("update tbl_member set f_name='".$f_name."', l_name='".$l_name."',full_name='".$full_name."', phone='".$phone."',fax='".$fax."',baddress='".$baddress."',bzip_code='".$bzip_code."', bcity='".$bcity."', bstate='".$bstate."', bcountry='".$bcountry."',saddress='".$saddress."',szip_code='".$szip_code."', scity='".$scity."',company_name='".$company_name."', sstate='".$sstate."', scountry='".$scountry."' where member_id='$member_id'");
		
		set_session_msg("Member has been updated successfully");
	?>
	<script language="javascript">location.href='member_listing.php'</script>
	<? exit;
	}
	else{
		set_session_msg("Username already exist.");
	}
}
if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$member_id=$_REQUEST['member_id'];
	$sql_fectch_city=mysql_query("select  * from tbl_member  where member_id=$member_id") or die(mysql_error());
	$fetch_record=mysql_fetch_array($sql_fectch_city);
	@extract($fetch_record);
	
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>
<center class="msg"><?=$msg;?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td id="pageHead"><div id="txtPageHead">
		<? if($_REQUEST['set_flag']=='update')
		echo "Edit Member"; else echo "Add Member";?></div></td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td id="content" align="center">
			<strong class="msg"><?=display_sess_msg()?></strong>
			
			<form method="post" name="checkout" action="" onsubmit="return validate(this);">
			<br />
			<table  border="0" align="center" width="70%" cellpadding="2" cellspacing="0" class="tableSearch">
				<tr align="center">
					<th colspan="2">
					<? if($_REQUEST['set_flag']=='update')
					echo "Edit Member"; else echo "Add Member";?></th>
				</tr>
				<tr>
					<td valign="top" colspan="3" align="right"><a href="member_listing.php">Back to Member Listing</a></td>
				</tr>
				<tr bgcolor="#f1f1f1">
					<td valign="top"class="tdLabel" colspan="3"><b>Login Info </b></td>
				</tr>
				<tr>
					<td valign="top" colspan="3">&nbsp;</td>
				</tr>
				<? 
				($_REQUEST['set_flag']=='update')?$readonly="readonly":$readonly="";	
				?>
				<tr>
					<td valign="top" class="tdLabel">Email/Username&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="email" type="text" value="<?=$username?>" id="NOBLANK~Please enter Email Id / Username~DM~EMAIL~Please enter valid email id~DM~" <?=$readonly?> onchange="showHint7(this.value);"/>
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top"><span class="red"><b><div id="txtHint7"></div></b></span></td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Password&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="pass" type="password" value="<?=$pass?>" id="NOBLANK~Please enter password~DM~" <?=$readonly?>/>
					</td>
				</tr>
				<?
				if($_REQUEST[set_flag]!="update"){
				?>
				<tr>
					<td valign="top" class="tdLabel">Confirm Password&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="cpass" type="password" value="<?=$cpass?>" id="NOBLANK~Please enter Confirm password~DM~CONFIRMPASSWORD~Confirm passwod mismatch~DM~" <?=$readonly?>/>
					</td>
				</tr>
				<?
				}
				?>
				<tr bgcolor="#f1f1f1">
					<td valign="top"class="tdLabel" colspan="3"><b>Personal Details</b></td>
				</tr>
				<tr>
					<td valign="top" colspan="3"><strong><font color="red"><?=display_sess_msg();?></font></strong></td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">First Name&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="f_name" type="text" value="<?=$f_name?>" id="NOBLANK~Please enter first name~DM~ALPHA~Number and special character not allowed in first name field~DM~"/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">Last Name&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="l_name" type="text" value="<?=$l_name?>" id="NOBLANK~Please enter last name~DM~ALPHA~Number and special character not allowed in last name field~DM~"/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">Company Name</td>
					<td class="tdLabel">
						<input name="company_name" type="text" value="<?=$company_name?>"/>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Telephone No.&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="phone" type="text" value="<?=$phone?>" id="NOBLANK~Please enter Telephone No~DM~PHONE~Phone~DM~" />
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">Fax No.</td>
					<td class="tdLabel">
						<input name="fax" type="text" value="<?=$fax?>"/>
					</td>
				</tr>
				<tr bgcolor="#f1f1f1">
					<td valign="top"class="tdLabel" colspan="3"><b>Billing Address</b></td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Address&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<textarea name="baddress" cols="40" rows="6" id="NOBLANK~Please enter billing address~DM~"><?=$baddress?></textarea>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Zip Code</td>
					<td class="tdLabel">
						<input name="bzip_code" type="text" value="<?=$bzip_code?>"/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">City&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="bcity" type="text" value="<?=$bcity?>" id="NOBLANK~Please enter billing city~DM~"/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">State&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="bstate" type="text" value="<?=$bstate?>" id="NOBLANK~Please enter billing state~DM~"/>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Country&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<select name="bcountry" id="NOBLANK~Please select billing country~DM~" style="width:200px;">
							<option value="">------------Select--------</option>
							<?
							$cont_sql=db_query("select * from tbl_country_master");
							while($cont_dtl=mysql_fetch_array($cont_sql)){
								($cont_dtl[contName]==$bcountry)?$sel="selected":$sel="";
								?>
								<option value="<?=$cont_dtl[contName]?>" <?=$sel?>><?=$cont_dtl[contName]?></option>
								<?	
							}
							?>
						</select>
					</td>
				</tr>
				
				<tr bgcolor="#f1f1f1">
					<td valign="top"class="tdLabel"><b>Shipping Address</b></td>
					<td valign="top"class="tdLabel"><input type="checkbox" name="sameaddress" onclick="return shipping_address()"><strong>Same as Billing Address?</strong></td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Address &nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<textarea name="saddress" cols="40" rows="6" id="NOBLANK~Please enter shipping address~DM~"><?=$saddress?></textarea>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Zip Code</td>
					<td class="tdLabel">
						<input name="szip_code" type="text" value="<?=$szip_code?>"/>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">City&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="scity" type="text" value="<?=$scity?>" id="NOBLANK~Please enter shipping city~DM~"/>
						 
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel">State&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<input name="sstate" type="text" value="<?=$sstate?>" id="NOBLANK~Please enter shipping state~DM~"/>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="tdLabel">Country&nbsp;<span class="red">*</span></td>
					<td class="tdLabel">
						<select name="scountry" id="NOBLANK~Please select shipping country~DM~" style="width:200px;">
							<option value="">------------Select--------</option>
							<?
							$scont_sql=db_query("select * from tbl_country_master");
							while($scont_dtl=mysql_fetch_array($scont_sql)){
								($scont_dtl[contName]==$scountry)?$ssel="selected":$ssel="";
								?>
								<option value="<?=$scont_dtl[contName]?>" <?=$ssel?>><?=$scont_dtl[contName]?></option>
								<?	
							}
							?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="2">
						<? if($_REQUEST['set_flag']=='update'){?>
						<input type="submit" class="btn btn-info"  name="update" value='Edit' >
						<? 
						}else {?>
						<input type="submit" class="btn btn-info"  name="submit" value='Submit' >
						<? 
						}?>
					</td>
				</tr>
		</table>
	</form>
	<br />
	<? include("paging.inc.php");?>
	</td>
</tr>
</table>
<? include("bottom.inc.php");?>