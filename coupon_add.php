<?php
$menu_active = "cupones";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
@extract($_POST);
$id=$_GET['id'];

/****************************** Add A new Coupon *************************************/
if(isset($_REQUEST['submit']))
{
	$found=mysql_num_rows(db_query("select * from tbl_coupon where coupon='$_REQUEST[coupon]'"));
	
	if($found==0){
		$coupon	=	addslashes($_REQUEST['coupon']);
		$flat_discount = $_REQUEST['flat_discount'];
		$percentile = $_REQUEST['percentile'];
		
		$sql_insert=mysql_query("insert into tbl_coupon set
		coupon='$coupon',
		flat_discount='$flat_discount',
		percentile ='$percentile',
		add_date = curdate(),
		status='1'") or die(mysql_error());
		
		set_session_msg("Cupón agregado correctamente");?>
		
		<script language="javascript">location.href='manage_coupon.php'</script>
		<?php exit;
	}else{
		set_session_msg("Cupón existente.");	
	}
	
}

/******************************************************************************************************/
if(isset($_REQUEST['update']))
{
	$found=mysql_num_rows(db_query("select * from tbl_coupon where coupon='$_REQUEST[coupon]' and id !='$_GET[id]'"));
	if($found==0)
	{
		$coupon	=	addslashes($_REQUEST['coupon']);
		$flat_discount = $_REQUEST['flat_discount'];
		$percentile = $_REQUEST['percentile'];
		
		$sql_update=mysql_query("update tbl_coupon set
		coupon='$coupon',
		flat_discount='$flat_discount',
		percentile ='$percentile',
		status='1' where id='".$id."'") or die(mysql_error());
		
		set_session_msg("Cupón actualizado");
		?>
		<script language="javascript">location.href='manage_coupon.php'</script>
		<?php exit;
	}else{
		set_session_msg("Error 172.");		
	}
}
if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$sql_fectch_city=mysql_query("select * from tbl_coupon  where id=$id") or die(mysql_error());
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
                            <label class="col-sm-3 control-label"> Código descuento <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^[a-zA-Z0-9]+$" data-validation="required" data-validation-error-msg="Ingrese un código de descuento" class="form-control" name="coupon"  size="48" type="text" value="<?=stripslashes($coupon)?>" />
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Descuentpo (S/.) <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese unacantidad válida, enteros o decimales." class="form-control" name="flat_discount" size="8" type="text" value="<?=$flat_discount?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Porcentaje (%) <span class="star">*</span></label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese unacantidad válida, enteros o decimales." class="form-control" name="percentile" size="8" type="text" value="<?=$percentile?>" />
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <a class="btn btn-default" href="<?=$_SERVER[HTTP_REFERER]?>">Volver</a>
                                <?php if($_REQUEST['set_flag']=='update'){?>
                                        <input type="submit" class="btn btn-info" name="update" value='Actualizar' >
                                <?php }else{?>
                                        <input type="submit" class="btn btn-info" name="submit" value='Agregar' >
                                <?php }?>
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