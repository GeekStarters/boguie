<?php
$menu_active = "publicidad";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

if(isset($_REQUEST['submit']))
{
    $url = addslashes($_REQUEST['url_open']);

    if($_FILES[banner][tmp_name]!=''){
            list($width, $height) = getimagesize($_FILES[banner]['tmp_name']);
            if(($width == "302" && $height == "50") || ($width == "320" && $height == "600")){
                $banner = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[banner]['name']);
                $banner = str_replace(' ','-',$banner);
                copy($_FILES[banner]['tmp_name'], "ads/".$banner) or die("Error con imagen");
            }else{
                set_session_msg("Las dimenciones de la imagen deben ser 302 x 50px ó 320x600 px");
                ?><script language="javascript">location.href='ads_add.php'</script>
                <?php
                exit;
            }
    }

    $sql_insert = mysql_query("insert into publicidad set url_open='".$url."', src_banner='".$banner."', status='Active'") or die(mysql_error());
    set_session_msg("Banner guardado correctamente");?>

    <script language="javascript">location.href='manage_ads.php'</script>
    <?php exit;
}

if(isset($_REQUEST['update'])){
	
    $url = addslashes($_REQUEST['url_open']);
    $ads_id = $_REQUEST['ads_id'];

    if($_FILES[banner][tmp_name]!=''){
            $ads_res = mysql_fetch_array(db_query("select * from publicidad where id_publicidad='$ads_id'"));

            if(strlen($ads_res[src_banner]) && file_exists("ads/".$ads_res[src_banner])){
                    unlink("ads/".$ads_res[src_banner]);
            }

            $banner = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[banner]['name']);
            copy($_FILES[banner]['tmp_name'],"ads/".$banner) or die("Error al subir la imagen");	
            db_query("update  publicidad set src_banner='".$banner."' where id_publicidad='".$ads_id."'");	
    }

    $sql_update="update  publicidad set url_open='".$url."' where id_publicidad='".$ads_id."'";
    #	die($sql_update);
    $sql_update=mysql_query($sql_update) or die(mysql_error());
    set_session_msg("Banner actualizado correctamente");?>

    <script language="javascript">location.href='manage_ads.php'</script>
    <?php exit;
	
}

if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$ads_id=$_REQUEST['ads_id'];
	$sql_fectch_city=mysql_query("select * from publicidad  where id_publicidad=$ads_id") or die(mysql_error());
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
                    $title_bread = "Editar banner";
                    
                } else {
                    $title_bread = "Agregar banner";
                    
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
                            <label class="col-sm-3 control-label">URL<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="url" data-validation="required" data-validation-error-msg="Ingrese una URL válida" name="url_open" class="form-control"  type="text" value="<?=stripslashes($url_open)?>" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Imagen del banner<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input 
                                    data-validation="mime size dimension" 
                                    data-validation-allowing="jpg, png" 
                                    data-validation-max-size="2M"
                                    data-validation-dimension="302x50-320x600"
                                    data-validation-error-msg-size="El tamaño máximo para la imagen del banner es 2 MB"
                                    data-validation-error-msg-mime="Selecciona una imagen en formato JPG o PNG únicamente"
                                    data-validation-error-msg-dimension="Las dimenciones de la imagen deben ser 302 x 50px ó 320x600px"
                                    class="form-control" id="banner" name="banner" type="file" ><br>
                                <?php if($src_banner){?>
                                Imagen Actual: 
					<img src="ads/<?=$src_banner?>" border="0"><br>
					<?php }?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <a class="btn btn-default" href="manage_ads.php">Volver</a>
                                    <?php if($_REQUEST['set_flag']=='update'){?>
                                        <input type="submit" class="btn btn-info" name="update" value='Actualizar' >
                                <?php }else{?>
                                        <input type="submit" class="btn btn-info"  name="submit" value='Guardar' >
                                <?php }?>
                                        <input type="button" id="check" class="btn btn-danger" value='Check' >
                            </div>
                        </div>

                        </form>

		</div>
	</div>
</div>
<?php
include './footer.php';
?>
<script> $.validate({
    modules : 'file'
}); </script>
</body>
</html>