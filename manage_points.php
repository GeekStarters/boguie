<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="./src/jquery.table2excel.js"></script>
<?php require_once("includes/main.inc.php");


if(isset($_REQUEST['min']) && isset($_REQUEST['max']) && isset($_REQUEST['discount'])){
	$min = $_REQUEST['min'];
	$max = $_REQUEST['max'];
	$date = $_REQUEST['add_date'];
	$discount = $_REQUEST['discount'];
	$query = "SELECT * FROM tbl_user WHERE points >= '$min' AND points <='$max'";
	$found = mysql_num_rows(db_query($query));
	if ($found > 0) {
		$result = db_query($query);
			$passangerEmail;
            while($row = mysql_fetch_assoc($result)){ $passangerEmail =  $row['email']; } 
            $passanger_regID= array();
            $sel_query = mysql_query("SELECT * FROM gcm_users where email='$passangerEmail' ");
            $passanger_regID[] = $row['gcm_regid'];
            $push_date = date("F j, Y, g:i a");
            $value = "Felicidades tienes un nuevo descuento para tu proxima carrera de $discount valido hasta el $date";
            $msg ="[$push_date][$value]";
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $driver_regID;
            $message = array("discount_action" => $msg);
            $result = $gcm->send_notification($registatoin_ids, $message);


		
		$query = db_query("UPDATE tbl_user SET discount='$discount', points='0', valid_until='$date' WHERE points >= $min AND points <='$max'");

	} else {
	    echo "0 results";
	}
	
}elseif (isset($_REQUEST['min']) && isset($_REQUEST['max'])){
	$min = $_REQUEST['min'];
	$max = $_REQUEST['max'];
	$query = "SELECT * FROM tbl_user WHERE points >= '$min' AND points <='$max'";
	$found = mysql_num_rows(db_query($query));
	if ($found > 0) {
		$result = db_query($query);
	} else {
	    echo "0 results";
	}
	
}

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<? include("top.inc.php");?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#add_date" ).datepicker();
  });
</script>
<center class="msg"><?=$msg;?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td id="pageHead"><div id="txtPageHead">Puntos Chiclayo</div></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td id="content" align="center"><strong class="msg"><?=display_sess_msg()?></strong>
			<form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>  style="width:400px;">
			 	<div class="form-group" >
				<label for="min">Carreras minimas:</label> 
				<input type="number" name="min" id="min" class="form-control" value="<?php echo htmlspecialchars($_REQUEST['min']); ?>"><br>
				</div>
				<div class="form-group">
				<label for="max">Carreras maximas:</label> 
				<input type="number" name="max" id="max" class="form-control" value="<?php echo htmlspecialchars($_REQUEST['max']); ?>"><br>
				</div>
				<div class="form-group">
				<label for="discount">Descuento a otorgar:</label> 
				<input type="number" name="discount" id="discount" class="form-control"><br>
				</div>
				<div class="form-group">
				<label for="discount">Valido hasta:</label> 
				<input type="text" name="add_date" id="add_date" class="form-control"><br>
				</div>
        		<input type="submit" class="btn btn-info">
			</form>
			<? if($found > 0){?>
			<table class="table table-hover" id="export">
			<thead>
				<tr>
					<th>id</th>
					<th>Nombre</th>
					<th>Email</th>
					<th>Descuento activo</th>
				</tr>
			</thead>
			<? while ($line_raw = ms_stripslashes(mysql_fetch_array($result))) {  ?>
			<tbody>
				<tr>
				 	<th><?= $line_raw['id']; ?></th>
				 	<th><?= $line_raw['fullname']; ?></th>
				 	<th><?= $line_raw['email']; ?></th>
				 	<th><?= $_REQUEST['discount']; ?></th>
				</tr>
				<? } ?>
			</table>
			<? }?>
		<br />
	</td>
</tr>
</table>

<? include("bottom.inc.php");?>








