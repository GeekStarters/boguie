<?php
$menu_active = "descuento";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
@extract($_POST);
$id=$_GET['id'];

$cliente = db_query("SELECT id, fullname, email FROM tbl_user WHERE id=".$_GET['cli']) or die(mysql_error());
$cliente_result = mysql_fetch_array($cliente);
extract($cliente_result);
if($cliente_result['id'] == ""){
    exit();
}
//print_r($cliente_result['fullname']);

/****************************** Add A new Coupon *************************************/
if(isset($_REQUEST['submit']))
{
	$found=mysql_num_rows(db_query("select * from tbl_coupon where coupon='$_REQUEST[coupon]'"));
        $activo_des =mysql_num_rows(db_query("select * from tbl_coupon where id_user=".$cliente_result['id']." and status='1'"));
        
        $carreras = db_query("SELECT COUNT(tbl_ride.passenger) as carreras from tbl_ride INNER JOIN tbl_user ON tbl_ride.passenger = tbl_user.id WHERE tbl_user.id = ".$cliente_result['id']." GROUP BY tbl_ride.passenger;");
        $carreras_result = mysql_fetch_array($carreras);
        extract($carreras_result);
        $carreras = $carreras_result['carreras'];
	
	if($found > 0){
            set_session_msg("Cupón existente.");
        }elseif($activo_des > 0){
            set_session_msg("El cliente ya tiene un descuento activo");	
        }else{
            $coupon	= addslashes($_REQUEST['coupon']);
            $flat_discount = $_REQUEST['flat_discount'];
            $percentile = $_REQUEST['percentile'];
            $add_date = $_REQUEST['hasta'];
            $id_user = $cliente_result['id'];

            $sql_insert=mysql_query("insert into tbl_coupon set
            coupon='$coupon',
            id_user='$id_user',
            flat_discount='$flat_discount',
            percentile ='$percentile',
            add_date = '$_REQUEST[hasta]',
            accumulated = '$carreras',
            status=1") or die(mysql_error());

            set_session_msg("Descuento agregado correctamente");?>

            <script language="javascript">location.href='descuento_cliente.php'</script>
            <?php exit;
	}
	
}

/******************************************************************************************************/
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#hasta').datepicker({ 
        dateFormat: 'yy-mm-dd',
        yearRange: "<?php echo date("Y");?>:<?php echo date("Y")+10;?>",
        changeMonth: true,
        changeYear: true});
});
</script>
</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
                <?php if($_REQUEST['set_flag']=='update') {
                    $title_bread = "Editar descuento";
                    
                } else {
                    $title_bread = "Agregar descuento";
                    
                }
			include("top.inc.php");
		?>
            <div class="row">
                <?=display_sess_msg()?>
                <center class="msg"><?=$msg;?></center>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-horizontal form-groups-b" method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate(this);">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Descuento para:</label>
                            <div class="col-sm-5">
                                <h4><?php echo $cliente_result['fullname']." (".$cliente_result['email'].")" ?></h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"> Código descuento <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[a-zA-Z0-9]+$" data-validation="required" data-validation-error-msg="Ingrese un código de descuento" class="form-control" name="coupon"  size="48" type="text" value="<?=stripslashes($coupon)?>" />
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Descuentpo (S/.) <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese unacantidad válida, enteros o decimales." class="form-control" name="flat_discount" size="8" type="text" value="<?=$flat_discount?>" />
                                <input name="id_user" type="hidden" value="<?php echo $cliente_result['id'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Válido hasta: <span class="star">*</span></label>
                            
                            <div class="col-sm-5">
                                <div class="input-group">
                                <input data-validation="required" data-validation-error-msg="Seleccione una fecha" name="hasta" id="hasta" class="form-control datepicker" value="<?php echo $add_date; ?>" data-format="D, dd MM yyyy" type="text" readonly="">
                                <div class="input-group-addon">
                                        <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <a class="btn btn-default" href="descuento_cliente.php">Volver</a>
                                    <input type="submit" class="btn btn-info" name="submit" value='Agregar' >
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php include("paging.inc.php");?>
                </div>
            </div>
        </div>
</div>

<?php
include './footer.php';
?>
<script> $.validate(); </script>
</body>
</html>