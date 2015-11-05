<?php
$menu_active = "taxi";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
@extract($_POST);
$id=$_GET['id'];

/****************************** Add A new CAB *************************************/
if(isset($_REQUEST['submit']))
	{
	$found=mysql_num_rows(db_query("select * from tbl_cab where cab_number='$_REQUEST[cab_number]'"));
	
	if($found==0){
		$cab_number	=	addslashes($_REQUEST['cab_number']);
		$fare_per_hour = 0;
		$fare_per_km = $_REQUEST['fare_per_km'];
		$cab_manufacter = $_REQUEST['cab_manufacter'];
		$cab_model = $_REQUEST['cab_model'];
		$cab_plate = $_REQUEST['cab_plate'];
		$cab_year = $_REQUEST['cab_year'];
		$cab_maintenance = $_REQUEST['cab_maintenance'];
		$assurance_company = $_REQUEST['assurance_company'];
		$SOAT = $_REQUEST['SOAT'];
		$soat_start = $_REQUEST['soat_start'];
		$soat_finish = $_REQUEST['soat_finish'];
		$waiting_charge_per_10_min = 0;
		
		if($_FILES[cab_image1][size]>0)
		{
			$cab_images_1	 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[cab_image1]['name']);
			$cab_images_1	 = str_replace(' ','-',$cab_images_1);
			copy($_FILES[cab_image1]['tmp_name'], "cab_images/".$cab_images_1) or die("Error con la imagen");	
			
			$thumb2 = new Thumbnail("cab_images/$cab_images_1");
			$thumb2->resize("600","725");
			$thumb2->save("cab_images/large/$cab_images_1","100%");
			
			$thumb = new Thumbnail("cab_images/$cab_images_1");
			$thumb->resize("150","200");
			$thumb->save("cab_images/$cab_images_1","100%");
		}
		
		$sql_insert=mysql_query("insert into tbl_cab set
		cab_number='$cab_number',
		category='$cat_id',
		fare_per_hour ='$fare_per_hour',
		fare_per_km = '$fare_per_km',
		waiting_charge_per_10_min = '0',
		cab_image1='$cab_images_1',
		cab_manufacter='$cab_manufacter',
		cab_model='$cab_model',
		cab_plate='$cab_plate',
		cab_year='$cab_year',
		cab_maintenance='$cab_maintenance',
		assurance_company='$assurance_company',
		SOAT='$SOAT',
		soat_start='$soat_start',
		soat_finish='$soat_finish',
		status='1'") or die(mysql_error());
		
		set_session_msg("Unidad agregada correctamente");?>
		
		<script language="javascript">location.href='manage_cab.php'</script>
		<?php exit;
	}else{
		set_session_msg("Unidad ya existe.");	
	}
	
}

/******************************************************************************************************/
if(isset($_REQUEST['update']))
{
	$found=mysql_num_rows(db_query("select * from tbl_cab where cab_number='$_REQUEST[cab_number]' and id !='$_GET[id]'"));
	if($found==0)
	{
		$cab_number	=	addslashes($_REQUEST['cab_number']);
		$fare_per_hour = $_REQUEST['fare_per_hour'];
		$fare_per_km = 0;
		$cab_manufacter = $_REQUEST['cab_manufacter'];
		$cab_model = $_REQUEST['cab_model'];
		$cab_plate = $_REQUEST['cab_plate'];
		$cab_year = $_REQUEST['cab_year'];
		$cab_maintenance = $_REQUEST['cab_maintenance'];
		$assurance_company = $_REQUEST['assurance_company'];
		$SOAT = $_REQUEST['SOAT'];
		$soat_start = $_REQUEST['soat_start'];
		$soat_finish = $_REQUEST['soat_finish'];
		$waiting_charge_per_10_min = 0;
		
		if($_FILES[cab_image1][size] > 0){
			$cat_res=mysql_fetch_array(db_query("select * from tbl_cab where id='$id'"));
			if(strlen($cat_res[cab_image1]) && file_exists("cab_images/".$cat_res[cab_image1])){
				unlink("/cab_images/".$cat_res[cab_image1]);
				unlink("/cab_images/large/".$cat_res[cab_image1]);
			}
			$cab_images_1 = md5(uniqid(rand(), true)).'.'.file_ext($_FILES[cab_image1]['name']);
			copy($_FILES[cab_image1]['tmp_name'],"cab_images/".$cab_images_1) or die("Error con la imagen");	
			
			$thumb2 = new Thumbnail("cab_images/$cab_images_1");
			$thumb2->resize("600","725");
			$thumb2->save("cab_images/large/$cab_images_1","100%");
						
			$thumb = new Thumbnail("cab_images/$cab_images_1");
			$thumb->resize("150","200");
			$thumb->save("cab_images/$cab_images_1","100%");
			
			db_query("update tbl_cab set cab_image1='".$cab_images_1."' where id='".$id."'");	
		}
		
		$sql_update=mysql_query("update tbl_cab set
		cab_number='$cab_number',
		category='$cat_id',
		fare_per_hour ='$fare_per_hour',
		fare_per_km = '$fare_per_km',
		waiting_charge_per_10_min = '0',
		cab_manufacter='$cab_manufacter',
		cab_model='$cab_model',
		cab_plate='$cab_plate',
		cab_year='$cab_year',
		cab_maintenance='$cab_maintenance',
		assurance_company='$assurance_company',
		SOAT='$SOAT',
		soat_start='$soat_start',
		soat_finish='$soat_finish',
		status='1' where id='".$id."'") or die(mysql_error());
		
		set_session_msg("Unidad actualizada correctamente");
		?>
		<!-- -->
		<script language="javascript">location.href='manage_cab.php'</script>
		
		<?php exit;
	}else{
		set_session_msg("Error.");		
	}
}
if(isset($_REQUEST['set_flag']) && $_REQUEST['set_flag']=='update'){
	$category_id=$_REQUEST['category_id'];
	$sql_fectch_city=mysql_query("select * from tbl_cab  where id=$id") or die(mysql_error());
	$fetch_record=mysql_fetch_array($sql_fectch_city);
	@extract($fetch_record);
}
?>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
	$('#cab_year').datepicker({ 
            dateFormat: 'yy-mm-dd',
            yearRange: "1990:<?php echo date("Y");?>",
            changeMonth: true,
            changeYear: true}).val();
	$('#cab_maintenance').datepicker({ 
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true}).val();
	$('#soat_start').datepicker({ 
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true}).val();
	$('#soat_finish').datepicker({ 
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true}).val();


  	$( "#cab_year_img" ).click(function() {
  		$('#cab_year').datepicker('show');
	});

	$( "#cab_maintenance_img" ).click(function() {
  		$('#cab_maintenance').datepicker('show');
	});

	$( "#soat_start_img" ).click(function() {
  		$('#soat_start').datepicker('show');
	});

	$( "#soat_finish_img" ).click(function() {
  		$('#soat_finish').datepicker('show');
	});



  });

  /*function validate(){
	valor = $("#fare_per_km").val();

	if(!$("#scab").val()) {
		alert("Seleccione una categoría");
		return false;
	}else if(!$("#cab_number").val()) {
		alert("Ingrese número de unidad");
		return false;
	}else if(!$("#cab_manufacter").val()) {
		alert("Ingrese la marca");
		return false;
	}else if(!$("#cab_model").val()) {
		alert("Ingrese el modelo");
		return false;
	}else if(!$("#cab_plate").val()) {
		alert("Ingrese la placa");
		return false;
	}else if(!$("#cab_year").val()) {
		alert("Ingrese fecha de compra");
		return false;
	}

  	 return true;

  }*/
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
                <?php if($_REQUEST['set_flag']=='update'){
                    $title_bread = "Editar unidad";
                }else{ 
                    $title_bread = "Agregar unidad";
                }
			include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <center class="msg"><?=$msg;?></center>
                    <?=display_sess_msg()?>
                </div>
            </div>
            
		<div class="row">
                    <div class="col-sm-12">
                        
  



            <form method="post" class="form-horizontal form-groups-b" action="" name="form2" id="form2" enctype="multipart/form-data" onsubmit="return validate();">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Categoría <span class="star">*</span></label>
                <div class="col-sm-5">
                    <select data-validation="length" data-validation-length="min1" data-validation-error-msg="Seleccione una opcion" class="form-control" name="cat_id" id="scab">
			<option value="">Select Catagory</option>
			<?php $sel="SELECT * FROM `tbl_category`";
			$exe=mysql_query($sel) or die("can't access");
			while($data=mysql_fetch_array($exe)){?> 
			<option value="<?=$data['cat_id']?>" <? if($fetch_record['category']==$data['cat_id']){ echo "selected"; }?>><?=$data['cat_name']?></option>
			<? }?>
                </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Número de unidad <span class="star">*</span></label>
                <div class="col-sm-5">
                    <input data-validation="custom" data-validation-regexp="^[a-zA-Z0-9]+$" data-validation="required" data-validation-error-msg="Ingrese un número válido" class="form-control" name="cab_number" id="cab_number" size="48" type="text" value="<?=stripslashes($cab_number)?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Marca <span class="star">*</span></label>
                <div class="col-sm-5">
                    <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" class="form-control" name="cab_manufacter" id="cab_manufacter"  size="48" type="text" value="<?=stripslashes($cab_manufacter)?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Modelo<span class="star">*</span></label>
                <div class="col-sm-5">
                    <input data-validation="custom" data-validation-regexp="^[\w ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" class="form-control" name="cab_model" id="cab_model" size="48" type="text" value="<?=stripslashes($cab_model)?>" />
                </div>
            </div>
            
             <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Placa<span class="star">*</span></label>
                <div class="col-sm-5">
                    <input data-validation="custom" data-validation-regexp="^[\w-]+$" data-validation="required" data-validation-error-msg="Ingrese un número de placa válido" class="form-control" name="cab_plate" id="cab_plate"  size="48" type="text" value="<?=stripslashes($cab_plate)?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Fecha compra<span class="star">*</span></label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input data-validation="required" data-validation-error-msg="Seleccione una fecha" class="form-control" id="cab_year" readonly name="cab_year"  size="48" type="text" value="<?=stripslashes($cab_year)?>" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Fecha último mantenimiento</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input class="form-control" readonly id="cab_maintenance" name="cab_maintenance"  size="48" type="text" value="<?=stripslashes($cab_maintenance)?>" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Empresa aseguradora</label>
                <div class="col-sm-5">
                    <input class="form-control" name="assurance_company" id="assurance_company" size="48" type="text" value="<?=stripslashes($assurance_company)?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">SOAT</label>
                <div class="col-sm-5">
                    <input class="form-control" name="SOAT"  size="48" type="text" value="<?=stripslashes($SOAT)?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Fecha inicio SOAT</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input class="form-control" readonly id="soat_start" name="soat_start"  size="48" type="text" value="<?=stripslashes($soat_start)?>" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Fecha fin SOAT</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input class="form-control" readonly id="soat_finish" name="soat_finish"  size="48" type="text" value="<?=stripslashes($soat_finish)?>" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Cobro por KM (S/.)</label>
                <div class="col-sm-5">
                    <input class="form-control" name="fare_per_km" id="fare_per_km" size="8" type="text" value="<?=$fare_per_km?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Imagen de unidad</label>
                <div class="col-sm-5">
                    <input class="form-control" name="cab_image1" type="file" ><br>
                    <?php if($cab_image1){?>
                    Imagen Actual: 
                    <img src="cab_images/<?=$cab_image1?>" border="0" height="102">
                    <?php }?>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <a  class="btn btn-default" href="manage_cab.php">Volver </a>
                    <?php if($_REQUEST['set_flag']=='update'){?>
                            <input type="submit" class="btn btn-info" name="update" value='Actualizar' >
                    <?php }else{?>
                            <input type="submit" class="btn btn-info" name="submit" value='Guardar' >
                    <?php }?>
                    
                </div>
            </div>
	
                    </form>
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