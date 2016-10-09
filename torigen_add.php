<?php
$menu_active = "torigen";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

if(isset($_REQUEST['submit']))
{
	$found=0;
	
	if($found==0){
		$nombre	=	addslashes($_REQUEST['nombre']);
		$desde	=	addslashes($_REQUEST['desde']);
		$hasta	=	addslashes($_REQUEST['hasta']);
		$costo	=	addslashes($_REQUEST['costo']);
		$horario_nocturno_desde	=	addslashes($_REQUEST['horario_nocturno_desde']);
		$horario_nocturno_hasta	=	addslashes($_REQUEST['horario_nocturno_hasta']);
		$factor_nocturno	=	addslashes($_REQUEST['factor_nocturno']);
		$factor_app	=	addslashes($_REQUEST['factor_app']);
		$status	=	addslashes($_REQUEST['status']);


		$sql_insert = mysql_query("insert into tarifas set nombre='".$nombre."',desde='".$desde."',hasta='".$hasta."',costo='".$costo."',horario_nocturno_desde='".$horario_nocturno_desde."',horario_nocturno_hasta='".$horario_nocturno_hasta."',factor_nocturno='".$factor_nocturno."',factor_app='".$factor_app."', status='".$status."'") or die(mysql_error());
		set_session_msg("Tarifa guardado correctamente");?>
		
		<script language="javascript">location.href='manage_torigen.php'</script>
		<?php 
		exit;
	}
}

if(isset($_REQUEST['update'])){
	$found=0;
	if($found==0){
		$origen	=	addslashes($_REQUEST['origen']);
        $sql_update = ("update tarifas set nombre='".$nombre."',desde='".$desde."',hasta='".$hasta."',costo='".$costo."',horario_nocturno_desde='".$horario_nocturno_desde."',horario_nocturno_hasta='".$horario_nocturno_hasta."',factor_nocturno='".$factor_nocturno."',factor_app='".$factor_app."', status='".$status."'") or die(mysql_error());

		//$sql_update="update  tarifario_origen set origen='".$origen."' where id='".$id."'";
		#	die($sql_update);
		$sql_update=mysql_query($sql_update) or die(mysql_error());
		set_session_msg("Tarifa actualizado correctamente");?>
		
		<script language="javascript">location.href='manage_torigen.php'</script>
		<?php exit;
	}
}

if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$id=$_REQUEST['id'];
	$sql_fectch_city=mysql_query("select * from tarifas  where id=$id") or die(mysql_error());
	$fetch_record=mysql_fetch_array($sql_fectch_city);
	@extract($fetch_record);
}
?>


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
                    $title_bread = "Editar tarifa";
                    
                } else {
                    $title_bread = "Agregar";
                    
                }
			include("top.inc.php");
		?>
            <div class="row">
                <?=display_sess_msg()?>
                <center class="msg"><?=$msg;?></center>
            </div>
		<div class="row">



                    <form class="form-horizontal form-groups-b" method="post" name="form2" id="form2" enctype="multipart/form-data" onsubmit="return validate(this);">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" name="nombre" class="form-control" size="32" type="text" value="<?=stripslashes($nombre)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Distancia desde<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese Distancia" name="desde" class="form-control" size="32" type="text" value="<?=stripslashes($desde)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Distancia hasta<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese Distancia" name="hasta" class="form-control" size="32" type="text" value="<?=stripslashes($hasta)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Costo<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese Costo" name="costo" class="form-control" size="32" type="text" value="<?=stripslashes($costo)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Horario Nocturno desde<span class="star">*</span></label>
							<div class="col-sm-5">
			                    <div class="input-group">
			                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
			                        <input data-validation="required" data-validation-error-msg="Seleccione hora" class="form-control" id="horario_nocturno_desde"  name="horario_nocturno_desde"  size="48" type="text" value="<?=stripslashes($horario_nocturno_desde)?>" />
			                    </div>
			                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Horario Nocturno hasta<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                                    <input data-validation="required" data-validation-error-msg="Seleccione hora" class="form-control" id="horario_nocturno_hasta"  name="horario_nocturno_hasta"  size="48" type="text" value="<?=stripslashes($horario_nocturno_hasta)?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Factor App<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese Factor App" name="factor_app" class="form-control" size="32" type="text" value="<?=stripslashes($factor_app)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Factor Nocturno<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese Factor Nocturno" name="factor_nocturno" class="form-control" size="32" type="text" value="<?=stripslashes($factor_nocturno)?>" />
                            </div>
                        </div>


                        <div class="form-group">
                        <label class="col-sm-3 control-label" for="pickup_address">Estado <span class="star">*</span></label>
                        <div class="col-sm-5">
                            <select name="status" id="status" class="form-control" style="margin-bottom: 15px;">
                            <? if($status == "active"){?>
                                    <option value="active" <? { echo "selected"; }?>>Activo</option>
                                    <option value="disable" >Desactivado</option>
                            <? } else { ?>
                                    <option value="active" >Activo</option>
                                    <option value="disable" <? { echo "selected"; }?>>Desactivado</option>
                            <? }?>
                            </select>
                        </div>
                        
              


                        
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-sm-offset-3 col-sm-5">
                                <a class="btn btn-default" href="manage_torigen.php">Volver</a>
                                    <?php if($_REQUEST['set_flag']=='update'){?>
                                        <input type="submit" class="btn btn-info" name="update" value='Actualizar' >
                                <?php }else{?>
                                        <input type="submit" class="btn btn-info"  name="submit" value='Guardar' >
                                <?php }?>
                            </div>
                        </div>

                        </form>

		</div>
	</div>
</div>
<?php
include './footer.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 <link rel="stylesheet" href="js/jquery.ui.timepicker.css">
<script src="js/jquery.ui.timepicker.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {

    $('#horario_nocturno_desde').timepicker({
        showNowButton: true,
        showDeselectButton: true,
        defaultTime: '',  // removes the highlighted time for when the input is empty.
        showCloseButton: true
    });

    $('#horario_nocturno_hasta').timepicker({
        showNowButton: true,
        showDeselectButton: true,
        defaultTime: '',  // removes the highlighted time for when the input is empty.
        showCloseButton: true
    });

  });

</script>
 <style type="text/css">
   #ui-timepicker-div *, *:before, *:after {
        -moz-box-sizing: border-box;
        box-sizing: content-box !important;
    }
 </style>
<script> $.validate(); </script>
</body>
</html>