<?php 
mysql_connect("localhost","root","");
mysql_select_db("cab");

extract($_POST);

if($submitForm == "yes"){
	$expdate = $mm . "/" . $yyyy;
	$sql = "insert into tbl_user set fullname='$fullname', email='$email', password='$passwd', mobile='$mobile', name_on_card='$name_on_card', card_num='$card_num', exp_date='$expdate', cvv_num='$cvv_num', balance='0', paid_yet='0', add_date=curdate(), usertype='user', status='1'";
	mysql_query($sql);
	
	header("Location: register.php");
	die;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CAB Application Registration Form</title>
</head>

<body>
<form method="post" name="frm" enctype="multipart/form-data">
<input type="hidden" name="submitForm" value="yes" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2"><div align="left"><strong>CAB Application Registration Form</strong> </div></td>
  </tr>
  <tr>
    <td width="110">Full Name: </td>
    <td><input type="text" name="fullname" size="30" /></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><input type="text" name="email" size="30" /></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input type="text" name="passwd" size="30" /></td>
  </tr>
  <tr>
    <td>Mobile:</td>
    <td><input type="text" name="mobile" size="30" /></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left"><strong>Credit Card Detail</strong> </div></td>
  </tr>
  <tr>
    <td>Name on Card: </td>
    <td><input type="text" name="name_on_card" size="30" /></td>
  </tr>
  <tr>
    <td>Card Number: </td>
    <td><input type="text" name="card_num" size="30" /></td>
  </tr>
  <tr>
    <td>Exp. Date </td>
    <td><input type="text" name="mm" size="8" />&nbsp;<input type="text" name="yyyy" size="15" /></td>
  </tr>
  <tr>
    <td>CVV Number: </td>
    <td><input type="text" name="cvv_num" size="8" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Submit" value="Submit" /></td>
  </tr>
</table>
</form>
</body>
</html>
