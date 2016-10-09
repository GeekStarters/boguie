<?php
$menu_active = "torigen";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

if(isset($_REQUEST['submit']))
{
	$found=mysql_num_rows(db_query("select * from tarifario_origen where origen='$_REQUEST[origen]'"));
	
	if($found==0){
		$origen	=	addslashes($_REQUEST['origen']);

		$sql_insert = mysql_query("insert into tarifario_origen set origen='".$origen."', status='Active'") or die(mysql_error());
		set_session_msg("Punto de origen guardado correctamente");?>
		
		<script language="javascript">location.href='manage_torigen.php'</script>
		<?php exit;
	}else{
		set_session_msg("Punto de origen ya existe.");	
	}
}

if(isset($_REQUEST['update'])){
	$found=mysql_num_rows(db_query("select * from tarifario_origen where origen='$_REQUEST[origen]' and id!='$_REQUEST[id]'"));
	
	if($found==0){
		$origen	=	addslashes($_REQUEST['origen']);
		$sql_update="update  tarifario_origen set origen='".$origen."' where id='".$id."'";
		#	die($sql_update);
		$sql_update=mysql_query($sql_update) or die(mysql_error());
		set_session_msg("Punto de origen actualizado correctamente");?>
		
		<script language="javascript">location.href='manage_torigen.php'</script>
		<?php exit;
	}else{
		set_session_msg("Punto de origen ya existente.");		
	}
}

if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$id=$_REQUEST['id'];
	$sql_fectch_city=mysql_query("select * from tarifario_origen  where id=$id") or die(mysql_error());
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
                    $title_bread = "Editar punto de origen";
                    
                } else {
                    $title_bread = "Agregar punto de origen";
                    
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
                            <label class="col-sm-3 control-label">Nombre del origen<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" name="origen" class="form-control" size="32" type="text" value="<?=stripslashes($origen)?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
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
<script> $.validate(); </script>
</body>
</html>