<?php
$menu_active = "tdestino";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

if(isset($_REQUEST['submit'])){
    
        $destino = addslashes($_REQUEST['destino']);
        $id_origen = $_REQUEST['id_origen'];
        $precio = $_REQUEST['precio'];
        
        $thissql = "select * from tarifario_destino where destino='".$destino."' and id_origen='".$id_origen."'";
        
	$found=mysql_num_rows(db_query($thissql));
        
        //print_r($thissql);
        //print_r($found);
        //exit();
	
	if($found==0){
		

		$sql_insert = mysql_query("insert into tarifario_destino set destino='".$destino."', id_origen='".$id_origen."', precio='".$precio."', status='Active'") or die(mysql_error());
		set_session_msg("Punto de destino guardado correctamente");?>
		
		<script language="javascript">location.href='manage_tdestino.php'</script>
		<?php exit;
	}else{
		set_session_msg("Punto de destino ya existe.");	
	}
}

if(isset($_REQUEST['update'])){
        $destino = addslashes($_REQUEST['destino']);
        $id_origen = $_REQUEST['id_origen'];
        $precio = $_REQUEST['precio'];
	$found=mysql_num_rows(db_query("select * from tarifario_destino where destino='".$destino."' and id_origen='".$id_origen."' and id!='$_REQUEST[id]'"));
	
	if($found==0){
		
		$sql_update="update  tarifario_destino set destino='".$destino."', id_origen='".$id_origen."', precio='".$precio."' where id='".$id."'";
		#	die($sql_update);
		$sql_update=mysql_query($sql_update) or die(mysql_error());
		set_session_msg("Punto de destino actualizado correctamente");?>
		
		<script language="javascript">location.href='manage_tdestino.php'</script>
		<?php exit;
	}else{
		set_session_msg("Punto de destino ya existente.");		
	}
}

if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$id=$_REQUEST['id'];
	$sql_fectch_city=mysql_query("select a.id, a.destino, a.precio, a.status, a.id_origen, b.origen from tarifario_destino as a INNER JOIN tarifario_origen as b WHERE a.id_origen = b.id and  a.id=$id") or die(mysql_error());
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
                    $title_bread = "Editar punto de destino";
                    
                } else {
                    $title_bread = "Agregar punto de destino";
                    
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
                            <label class="col-sm-3 control-label">Nombre del destino<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" name="destino" class="form-control" size="32" type="text" value="<?=stripslashes($destino)?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pickup_address">Origen <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <select data-validation="length" data-validation-length="min1" data-validation-error-msg="Seleccione una opcion" class="form-control" name="id_origen" id="scab">
                                    <option value="">Seleccione origen</option>
                                    <?php $sel="SELECT * FROM tarifario_origen";
                                    $exe=mysql_query($sel) or die("can't access");
                                    while($data=mysql_fetch_array($exe)){?> 
                                    <option value="<?=$data['id']?>" <?php if($fetch_record['id_origen']==$data['id']){ echo "selected"; }?>><?=$data['origen']?></option>
                                    <? }?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Precio <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="precio" size="32" type="text" value="<?=stripslashes($precio)?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <a class="btn btn-default" href="manage_tdestino.php">Volver</a>
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