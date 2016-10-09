<? require_once("includes/main.inc.php");

$sql_drivers = "SELECT * FROM tbl_user WHERE usertype='driver' AND taxi =''";
$sql_taxis = "SELECT * FROM tbl_cab WHERE with_driver='0'";
$result_drivers = mysql_query($sql_drivers);
$result_taxis = mysql_query($result_taxis);
?>
<script src="../js/validation.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<? include("top.inc.php");?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="pageHead"><div id="txtPageHead">Reporte por conductor</div></td>
</tr>
</table>

<select id="drivers" size="10">
	<?php 
		while ($line_raw = mysql_fetch_array($result_drivers, MYSQL_ASSOC)) {
	?>
	<option><?= $line_raw['fullname']; ?></option>
	<?php } ?>
</select>

<select id="taxis" size="10">
</select>


<?php include("bottom.inc.php");?>