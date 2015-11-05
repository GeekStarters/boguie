<?php
$menu_active = "categorias";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

if(isset($_REQUEST['submit']))
{
	$found=mysql_num_rows(db_query("select * from tbl_category where cat_name='$_REQUEST[category_name]'"));
	
	if($found==0){
		$category_name	=	addslashes($_REQUEST['category_name']);
		$cat_desc	=	addslashes($_REQUEST['cat_desc']);
		$parent_id = $_REQUEST['cat_parent_id'];
		
		if($_FILES[cat_image][tmp_name]!=''){
			$cat_image_1	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[cat_image]['name']);
			$cat_image_1	 = str_replace(' ','-',$cat_image_1);
			copy($_FILES[cat_image]['tmp_name'], "cab_images/".$cat_image_1) or die("Error con imagen");	
		}
		
		$sql_insert = mysql_query("insert into tbl_category set cat_name='".$category_name."', cat_parent_id='".$parent_id."', cat_desc='".$cat_desc."', cat_image='".$cat_image_1."', cat_status='Active'") or die(mysql_error());
		set_session_msg("Categoria guardad correctamente");?>
		
		<script language="javascript">location.href='manage_category.php'</script>
		<?php exit;
	}else{
		set_session_msg("Categoria ya existe.");	
	}
}

if(isset($_REQUEST['update'])){
	$found=mysql_num_rows(db_query("select * from tbl_category where cat_name='$_REQUEST[category_name]' and cat_id!='$_REQUEST[category_id]'"));
	
	if($found==0){
		$category_name	=	addslashes($_REQUEST['category_name']);
		$cat_desc	=	addslashes($_REQUEST['cat_desc']);
		$category_id	=	$_REQUEST['category_id'];
		$parent_id = $_REQUEST['cat_parent_id'];
		
		if($_FILES[cat_image][tmp_name]!=''){
			$cat_res=mysql_fetch_array(db_query("select * from tbl_category where cat_id='$category_id'"));
			
			if(strlen($cat_res[cat_image]) && file_exists("cab_images/".$cat_res[cat_image])){
				unlink("/cab_images/".$cat_res[cat_image]);
			}
			
			$cat_image_1 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[cat_image]['name']);
			copy($_FILES[cat_image]['tmp_name'],"cab_images/".$cat_image_1) or die("Image is not uploaded");	
			db_query("update  tbl_category set cat_image='".$cat_image_1."' where cat_id='".$category_id."'");	
		}
		
		$sql_update="update  tbl_category set cat_name='".$category_name."', cat_parent_id='".$parent_id."', cat_desc='".$cat_desc."' where cat_id='".$category_id."'";
		#	die($sql_update);
		$sql_update=mysql_query($sql_update) or die(mysql_error());
		set_session_msg("Categoria actualizada correctamente");?>
		
		<script language="javascript">location.href='manage_category.php'</script>
		<?php exit;
	}else{
		set_session_msg("Categoria ya existente.");		
	}
}

if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$category_id=$_REQUEST['category_id'];
	$sql_fectch_city=mysql_query("select * from tbl_category  where cat_id=$category_id") or die(mysql_error());
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
                    $title_bread = "Editar categoria";
                    
                } else {
                    $title_bread = "Agregar categoria";
                    
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
                            <label class="col-sm-3 control-label">Nombre categoria<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" name="category_name" class="form-control" size="32" type="text" value="<?=stripslashes($cat_name)?>" />
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Precio KM (S/.)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="per_km" size="32" type="text" value="<?=stripslashes($per_km)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Precio 10 Minutos (S/.)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="per_time" size="32" type="text" value="<?=stripslashes($per_time)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kilómetros mínimos (km)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un número válido" class="form-control" name="min_km" size="32" type="text" value="<?=stripslashes($min_km)?>" /> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Precio Minimo (S/.)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="min_fare" size="32" type="text" value="<?=stripslashes($min_fare)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Adicional por horario (S/.)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="scheduled_special" size="32" type="text" value="<?=stripslashes($scheduled_special)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Adicional por fin de semana (S/.)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="weekend_special" size="32" type="text" value="<?=stripslashes($weekend_special)?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Adicional por día festivo (S/.)<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un precio válido" class="form-control" name="festive_special" size="32" type="text" value="<?=stripslashes($festive_special)?>" />
                            </div>
                        </div>
                        -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Imagen categoria</label>
                            <div class="col-sm-5">
                                <input class="form-control" name="cat_image" type="file" ><br>
                                <?php if($cat_image){?>
                                Imagen Actual: 
					<img src="cab_images/<?=$cat_image?>" border="0"  height="102"><br>
					<?php }?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Descripción</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" name="cat_desc" id="cat_desc" rows="10" cols="50"><?=$cat_desc?></textarea>
                                	<script type="text/javascript">
						CKEDITOR.config.toolbar = 'Basic';
						CKEDITOR.replace('cat_desc',{
							height: '300px',
							width: '520px'
						});
					</script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <a class="btn btn-default" href="manage_category.php">Volver</a>
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