<?php
function validate_user()
{
	if($_SESSION['sess_stud_id']==''){
		$_SESSION['pageName']=$_SERVER['REQUEST_URI'];
		$_SESSION['sess_msg'] = "You are not logged in. Kindly login first to view the same. Please <a href='login.php?back=".urlencode(str_replace("/sangrock/","",$_SERVER['REQUEST_URI']))."' class='txtSmall BlueTxt'><strong>click here</strong></a> to login.";
		header("Location:msg.php");
		exit;
	}
}

function readmyfile($path)
{
	$text='';
	$fp = @fopen($path,"r");
	while (!@feof($fp))	{
		$buffer = @fgets($fp, 4096);
		$text.= $buffer;
	}
	@fclose($fp);
	return $text;
}

function protect_admin_page() {
	$cur_page = basename($_SERVER['PHP_SELF']);
	$arr = array(0=>'sub_admin_list.php',2=>'manage-owners.php',3=>'banner_list.php',5=>'add_sub_admin.php',6=>'banner_f.php');
	
	if($cur_page != 'index.php') {
		if ($_SESSION['sess_admin_id']=='') {
			$_SESSION['sess_msg'] = "Please login first.";
			header('Location: index.php');
			exit;
		}else{
			if($_SESSION['sess_admin_type']!='Super' && (in_array($cur_page,$arr))){
				set_session_msg("You have not permission to access this page.");
				header('Location: admin_welcome.php');
				exit;			  
			}
		}
	}else{
	    if($_SESSION['sess_admin_id']!='') {
			header('Location: admin_welcome.php');
			exit;
		}
	} 
}

function  getCountryName($country_id)
{
	$country_name='';
	$row=getDBRow('tbl_country_master',"contId='".$country_id."'",'contName');

	if(is_array($row)){
		$country_name=$row['contName'];
	}
	
	return $country_name; 
}

function getDBRow($table,$condition='',$field_list)
{
	if($table!='' && $field_list!=''){
		$sql="SELECT $field_list  FROM  $table  ";  
		
		if($condition!='') $sql.=" WHERE  $condition ";
		$rs=db_query($sql);
		
		if($rs){
			$row=mysql_fetch_array($rs);
		}
	}
	return $row;
}

function checkAvailableRecord($table,$field1,$condition)
{
	if($table!="" && $field1!="" && $condition!=""){
		$sql		=	"select $field1 from $table where $condition";
		$result	=	db_scalar($sql);
	}else{
		$result	=	0;
	}
	return $result;
}

function searchSingleRecord($table,$field1,$field2,$value)
{
	if($table!="" && $field1!="" && $field2!="" && $value!=""){
		$sql = "select $field1 from $table where $field2='".$value."'";
		$result	= db_scalar($sql);
		return $result;	
	}
}

function fetchRecArr($table,$field1,$condition)
{
	$row_arr	=	array();
	if($table!="" && $field1!=""){
		$query_res = mysql_query("select $field1 from $table where $condition");
		if(mysql_num_rows($query_res)==1){
			$row_arr=mysql_fetch_assoc($query_res);
		}
	}
	return $row_arr; 
}

function get_membername($mem_id)
{
	$name='';
	if($mem_id!='' && $mem_id!=0 && $mem_id!=-1){
		$tbl = "tbl_user";
		$auto_id = "u_id";
		$f1 = "u_fname,u_lname";
		
		$sql = "select $f1  from $tbl where $auto_id='$mem_id'";
		$result	= db_query($sql);
		
		if($result){
			$row=mysql_fetch_array($result);
			$name=$row[0];
			$row[1] != '' ? $name.=" ".$row[1]:false;
		}
	}elseif($mem_id==-1){
		$name='Admin';
	}
	
	return ucwords($name);
}

function get_user($u_id,$type)
{
	if($u_id!="" && $u_id!=0){
		if($type!="Admin"){
			return get_membername($u_id);
		}else{
			return get_adminname($u_id);
		}
	}
}

function get_adminname($id)
{
	if($id!="" && $id!=0){
		$name =	searchSingleRecord("tbl_admin","admin_name","admin_id",$id);   
		return $name;
	}
}

function count_character($str,$td_len)
{
	$length=strlen($str);
	if($length > $td_len){
		$i=$td_len;
		do{ 
			$i--;
		}while(substr($str,$i,1)!=" ");
		return substr($str,0,$i)."...";
	}else{
		return $str;
	}
}

function Count_Array()
{
	return count($_SESSION[Cart]);
}

function set_session_msg($msg)
{
	$_SESSION['sess_msg']=$msg;
}

function display_sess_msg()
{
	if($_SESSION['sess_msg']!=''){
		echo '<div class="msg-error alert alert-default">';
		echo $_SESSION['sess_msg'];
		echo "</div>";
                unset($_SESSION['sess_msg']); 
	}
}

function display_sess_msg1()
{
	if($_SESSION['sess_msg']!=''){
		echo $_SESSION['sess_msg'];
		unset($_SESSION['sess_msg']); 
	}
}

function get_first_paragraph($str)
{
	if($str!=""){
		$par = preg_split('#\s*</?p>\s*#', $str, -1, PREG_SPLIT_NO_EMPTY);
		return $par[0];
	}	
}

function sendMail($email_to,$emailto_name,$email_subject,$email_body,$email_from,$reply_to,$html=true,$attachment='')
{
	require_once "class.phpmailer.php";
	$mail = new PHPMailer();
	//$mail->IsSMTP(); // send via SMTP]
	$mail->IsMail(); // send via PHP mail function]
	$mail->Mailer   = "mail"; 
	//$mail->Host   = ""; // SMTP servers
	$mail->From     = buyananda;
	$mail->FromName = buyananda.com;
	$mail->AddAddress($email_to,$emailto_name); 
	
	$mail->AddReplyTo($reply_to,SITE_NAME);
	//$mail->WordWrap = 50;                              // set word wrap
	$mail->IsHTML($html);                               // send as HTML
	$mail->Subject  =  $email_subject;
	
	if($attachment!=''){
	  $mail->AddAttachment(UP_FILES_FS_PATH."/attachment/".$attachment);
	}
	$mail->Body     =  $email_body;
	if(!$mail->Send())
	{
		return false;
	}
	else
	{
		return true; 
	}
}

function generateInsertQuery($table)
{
	if($table!=""){
		$query="select * from $table";
		$result=db_query($query);
		$insert	= "Insert into $table values(";	
		$i = 0;
		
		while ($i < mysql_num_fields ($result)){
			$row = mysql_fetch_field ($result);
			$name = $row->name;
			$insert	.= " '$$name',";
			$i++;
		}	
		
		$insert	=	substr($insert,0,-1).")";
		return $insert;	
	}
}

function generateUpdateQuery($table)
{
	if($table!=""){
		$query="select * from $table";
		$result=db_query($query);
		$insert	=	"Update $table set ";	
		$i = 0;
		
		while ($i < mysql_num_fields ($result)) {
			$row = mysql_fetch_field ($result);
			$name	= $row->name;
			$insert	.= " $name='$$name',";	
			$i++;
		}	
		$insert	=	substr($insert,0,-1);
		return $insert;	
	}
}

function getRandomString($len=6)
{
	$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
	$max=strlen($base)-1;
	$code='';
	mt_srand((double)microtime()*1000000);
	
	while (strlen($code)<$len+1)
		$code.=$base{mt_rand(0,$max)};
	return $code;
		
}

function aspect_ratio($file_name,$max_width)
{
	$dim = @getimagesize($file_name);
	if($dim[0] > $max_width){
		$scale=$max_width/$dim[0];
		$height=ceil($scale*$dim[1]);
		$image[w] = $max_width;
		$image[h] = $height;
	}else{
		$image[w] = $dim[0];
		$image[h] = $dim[1];
    }

    return $image;
}

function emailmsg($id,$subject,$msg,$attach='')
{
	$str = $msg;
	$res	=	db_query("select nu_name,nu_email from tbl_newsletter where nu_id='$id'");
	if(mysql_num_rows($res)>0){
		$row=mysql_fetch_assoc($res);  
		@extract($row);
		sendMail($nu_email,$nu_name,$subject,$str,ADMIN_EMAIL,ADMIN_EMAIL,$html=true,$attach);
	}
}

function getText1($page_id){
	if($page_id!='' && $page_id!=0){
		$text	=	db_scalar("select page_text from tbl_content where page_id='$page_id'");
	}else{
		$text="&nbsp;";
	}
	
	return $text;
}

function getText2($page_id){
	if($page_id!='' && $page_id!=0)
		$text =	db_scalar("select page_brief_desc from tbl_content where page_id='$page_id'");
	else
		$text="&nbsp;";
	
	return $text;
}

function getmysqldatetime($ap_date)
{
	if($ap_date!=''){
		$dateArr = explode(' ',$ap_date);
		$date1 = explode('/',$dateArr[0]);
		$time1 = explode(':',$dateArr[1]);
		return $date=$date1[2]."-".$date1[1]."-".$date1[0]." ".$time1[0].":".$time1[1];
	}
}

function changedatefrommysqldate($ap_date)
{
	if($ap_date!='' && $ap_date!='0000-00-00' && $ap_date!='0000-00-00 00:00:00'){
		$dateArr = explode(' ',$ap_date);	
		$date = explode('-',$dateArr[0]);
		$time = explode(':',$dateArr[1]);
		return $date = $date[2]."/".$date[1]."/".$date[0]." ".$time[0].":".$time[1];
	}	  
}

function dateformat($ap_date)
{
	if($ap_date!='' && $ap_date!='0000-00-00' && $ap_date!='0000-00-00 00:00:00'){
		$dateArr = explode(' ',$ap_date);	
		$date =	explode('-',$dateArr[0]);
		$time = explode(':',$dateArr[1]);
		return $date = $date[2]."/".$date[1]."/".$date[0];
	}	  
}

function dateformat_txt($ap_date)
{
	if($ap_date!='' && $ap_date!='0000-00-00' && $ap_date!='0000-00-00 00:00:00'){
		$dateArr = explode(' ',$ap_date);	
		$date =	explode('-',$dateArr[0]);
		$time = explode(':',$dateArr[1]);
		return $date = date("d-M-Y", mktime(0,0,0,$date[1],$date[2],$date[0]));
	}	  
}

function getCategoryName($cid)
{
	$sql = "select cat_name from tbl_category where cat_id='".$cid."'";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc['cat_name'];
}
?>